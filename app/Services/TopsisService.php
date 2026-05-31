<?php

namespace App\Services;

use App\Models\Kriteria;
use App\Models\Wisata;
use Illuminate\Support\Facades\Http;

class TopsisService
{
    /**
     * Menghitung jarak lurus menggunakan Haversine Formula (C1)
     */
    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        // Mencoba mengambil jarak berkendara real dari OSRM API (Google Maps alternative)
        try {
            $response = Http::timeout(3)
                ->get("http://router.project-osrm.org/route/v1/driving/{$lon1},{$lat1};{$lon2},{$lat2}?overview=false");

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['routes'][0]['distance'])) {
                    // OSRM mengembalikan jarak dalam meter, kita ubah ke kilometer
                    return round($data['routes'][0]['distance'] / 1000, 2);
                }
            }
        } catch (\Exception $e) {
            // Jika API gagal atau timeout, fallback ke rumus Haversine
        }

        // Fallback: Haversine Formula (Jarak Lurus)
        $bumiRadius = 6371; // Radius bumi dalam kilometer
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($bumiRadius * $c, 2);
    }

    /**
     * Eksekusi Algoritma TOPSIS Lengkap dengan Langkah-langkah
     */
    public function hitungRekomendasiLengkap($userLat, $userLng, $kategoriMinat)
    {
        // Filter awal berdasarkan kategori minat wisatawan
        $wisatas = Wisata::with('penilaian')->where('kategori', $kategoriMinat)->get();
        if ($wisatas->isEmpty()) {
            return [];
        }

        $kriterias = Kriteria::orderBy('kode', 'asc')->get();

        // --- LANGKAH 1: MEMBENTUK MATRIKS KEPUTUSAN (X) ---
        $matriksX = [];
        foreach ($wisatas as $wisata) {
            // Hitung C1 (Jarak) secara otomatis berdasarkan titik pengguna
            $jarakKm = $this->hitungJarak($userLat, $userLng, $wisata->latitude, $wisata->longitude);
            $baris['C1'] = $jarakKm;

            // Tarik nilai C2, C3, C4 dari database
            foreach ($wisata->penilaian as $penilaian) {
                $kodeKriteria = $kriterias->where('id', $penilaian->kriteria_id)->first()->kode;
                $baris[$kodeKriteria] = $penilaian->nilai;
            }
            $matriksX[$wisata->id] = $baris;
        }

        // --- LANGKAH 2: NORMALISASI MATRIKS (R) ---
        // Mencari nilai pembagi (akar dari jumlah kuadrat)
        $pembagi = [];
        foreach ($kriterias as $k) {
            $kode = $k->kode;
            $sumKuadrat = 0;
            foreach ($matriksX as $idWisata => $baris) {
                $sumKuadrat += pow($baris[$kode], 2);
            }
            $pembagi[$kode] = $sumKuadrat == 0 ? 1 : sqrt($sumKuadrat);
        }

        // Membagi tiap nilai matriks dengan pembaginya
        $matriksR = [];
        foreach ($matriksX as $idWisata => $baris) {
            foreach ($kriterias as $k) {
                $kode = $k->kode;
                $matriksR[$idWisata][$kode] = $baris[$kode] / $pembagi[$kode];
            }
        }

        // --- LANGKAH 3: MATRIKS TERNORMALISASI TERBOBOT (Y) ---
        $matriksY = [];
        foreach ($matriksR as $idWisata => $baris) {
            foreach ($kriterias as $k) {
                $kode = $k->kode;
                $matriksY[$idWisata][$kode] = $baris[$kode] * $k->bobot;
            }
        }

        // --- LANGKAH 4: SOLUSI IDEAL POSITIF (A+) & NEGATIF (A-) ---
        $A_plus = [];
        $A_min = [];
        foreach ($kriterias as $k) {
            $kode = $k->kode;
            $kolomNilai = array_column($matriksY, $kode);

            if ($k->tipe == 'benefit') {
                $A_plus[$kode] = max($kolomNilai);
                $A_min[$kode] = min($kolomNilai);
            } else { // Jika tipe cost (Jarak & Harga) kebalikannya
                $A_plus[$kode] = min($kolomNilai);
                $A_min[$kode] = max($kolomNilai);
            }
        }

        // --- LANGKAH 5: MENGHITUNG JARAK SOLUSI IDEAL (D+ dan D-) ---
        $D_plus = [];
        $D_min = [];
        foreach ($matriksY as $idWisata => $baris) {
            $sumPlus = 0;
            $sumMin = 0;
            foreach ($kriterias as $k) {
                $kode = $k->kode;
                $sumPlus += pow($baris[$kode] - $A_plus[$kode], 2);
                $sumMin += pow($baris[$kode] - $A_min[$kode], 2);
            }
            $D_plus[$idWisata] = sqrt($sumPlus);
            $D_min[$idWisata] = sqrt($sumMin);
        }

        // --- LANGKAH 6: MENGHITUNG NILAI PREFERENSI (V) ---
        $preferensi = [];
        foreach ($wisatas as $wisata) {
            $id = $wisata->id;
            $d_plus_val = $D_plus[$id];
            $d_min_val = $D_min[$id];

            $totalD = $d_min_val + $d_plus_val;
            $nilaiV = $totalD == 0 ? 0 : $d_min_val / $totalD; // Rumus V = D- / (D- + D+)

            $preferensi[] = [
                'wisata' => $wisata,
                'jarak_km' => $matriksX[$id]['C1'], // Simpan info jarak mentah untuk UI
                'nilai_v' => round($nilaiV, 4), // Bulatkan 4 angka di belakang koma
            ];
        }

        // --- LANGKAH 7: PERANKINGAN ---
        // Urutkan array dari nilai V terbesar ke terkecil
        usort($preferensi, function ($a, $b) {
            return $b['nilai_v'] <=> $a['nilai_v'];
        });

        return [
            'kriterias' => $kriterias,
            'wisatas' => $wisatas,
            'matriksX' => $matriksX,
            'matriksR' => $matriksR,
            'matriksY' => $matriksY,
            'A_plus' => $A_plus,
            'A_min' => $A_min,
            'D_plus' => $D_plus,
            'D_min' => $D_min,
            'preferensi' => $preferensi,
            'hasil' => $preferensi,
        ];
    }

    /**
     * Eksekusi Algoritma TOPSIS dan Mengembalikan 5 Hasil Teratas
     */
    public function hitungRekomendasi($userLat, $userLng, $kategoriMinat)
    {
        $hasilLengkap = $this->hitungRekomendasiLengkap($userLat, $userLng, $kategoriMinat);

        return $hasilLengkap ? $hasilLengkap['hasil'] : [];
    }
}
