<?php

namespace App\Http\Controllers;

use App\Services\TopsisService;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    public function proses(Request $request, TopsisService $topsisService)
    {
        // 1. Validasi data yang dikirim dari form Blade
        $request->validate([
            'nama' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'kategori' => 'required|string',
        ]);

        // 2. Lempar data koordinat & minat ke otak TOPSIS lengkap
        $hasilLengkap = $topsisService->hitungRekomendasiLengkap(
            $request->latitude,
            $request->longitude,
            $request->kategori
        );

        if (! $hasilLengkap) {
            return redirect()->back()->with('error', 'Tidak ada destinasi wisata yang cocok dalam kategori ini.');
        }

        // Simpan hanya input pencarian ke session untuk halaman dashboard
        session([
            'last_topsis_inputs' => [
                'nama' => $request->nama,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'kategori' => $request->kategori,
            ],
        ]);

        // 3. Arahkan ke halaman hasil beserta datanya
        return view('hasil', [
            'namaWisatawan' => $request->nama,
            'kategori' => $request->kategori,
            'hasil' => $hasilLengkap['hasil'],
        ]);
    }
}
