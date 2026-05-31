<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Wisata;
use Illuminate\Database\Seeder;

class ProyekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pembuatan data master kriteria awal
        $kriterias = [
            ['kode' => 'C1', 'nama_kriteria' => 'Jarak', 'tipe' => 'cost', 'bobot' => 3.0],
            ['kode' => 'C2', 'nama_kriteria' => 'Harga Tiket', 'tipe' => 'cost', 'bobot' => 3.0],
            ['kode' => 'C3', 'nama_kriteria' => 'Rating', 'tipe' => 'benefit', 'bobot' => 2.0],
            ['kode' => 'C4', 'nama_kriteria' => 'Fasilitas', 'tipe' => 'benefit', 'bobot' => 3.0],
        ];

        foreach ($kriterias as $k) {
            Kriteria::create($k);
        }

        $wisatas = [
            // Kategori alam
            [
                'nama_wisata' => 'Lokawisata Baturraden',
                'deskripsi' => 'Kawasan wisata pegunungan ikonik di Banyumas dengan pemandangan alam dan air terjun.',
                'kategori' => 'Alam',
                'latitude' => -7.31381, 'longitude' => 109.22981,
                'penilaian' => ['C2' => 25000, 'C3' => 4.5, 'C4' => 6], // Fasilitas sangat lengkap (6)
            ],
            [
                'nama_wisata' => 'Hutan Pinus Limpakuwus',
                'deskripsi' => 'Hutan pinus asri di lereng Gunung Slamet, cocok untuk bersantai dan foto-foto.',
                'kategori' => 'Alam',
                'latitude' => -7.30199, 'longitude' => 109.24472,
                'penilaian' => ['C2' => 17500, 'C3' => 4.6, 'C4' => 5],
            ],
            [
                'nama_wisata' => 'Telaga Sunyi',
                'deskripsi' => 'Telaga jernih dengan air pegunungan yang dingin di tengah hutan yang tenang.',
                'kategori' => 'Alam',
                'latitude' => -7.30704, 'longitude' => 109.24322,
                'penilaian' => ['C2' => 15000, 'C3' => 4.6, 'C4' => 3], // Fasilitas standar (3)
            ],
            [
                'nama_wisata' => 'Curug Cipendok',
                'deskripsi' => 'Air terjun megah dengan ketinggian 92 meter yang dikelilingi hutan tropis.',
                'kategori' => 'Alam',
                'latitude' => -7.33621, 'longitude' => 109.13710,
                'penilaian' => ['C2' => 12000, 'C3' => 4.5, 'C4' => 4],
            ],
            [
                'nama_wisata' => 'Curug Jenggala',
                'deskripsi' => 'Air terjun dengan spot foto dek berbentuk hati yang sangat populer.',
                'kategori' => 'Alam',
                'latitude' => -7.30890, 'longitude' => 109.20879,
                'penilaian' => ['C2' => 15000, 'C3' => 4.7, 'C4' => 4],
            ],
            [
                'nama_wisata' => 'Curug Gomblang',
                'deskripsi' => 'Air terjun eksotis di lereng selatan Gunung Slamet, favorit anak muda.',
                'kategori' => 'Alam',
                'latitude' => -7.32357, 'longitude' => 109.18139,
                'penilaian' => ['C2' => 10000, 'C3' => 4.6, 'C4' => 3],
            ],
            [
                'nama_wisata' => 'Kebun Raya Baturraden',
                'deskripsi' => 'Kawasan konservasi tanaman dengan koleksi flora pegunungan Jawa.',
                'kategori' => 'Alam',
                'latitude' => -7.30618, 'longitude' => 109.23247,
                'penilaian' => ['C2' => 20000, 'C3' => 4.4, 'C4' => 5],
            ],

            // Kategori buatan
            [
                'nama_wisata' => 'Menara Pandang Teratai Purwokerto',
                'deskripsi' => 'Landmark modern dengan menara pandang setinggi 117 meter di pusat kota.',
                'kategori' => 'Buatan',
                'latitude' => -7.43128, 'longitude' => 109.23256,
                'penilaian' => ['C2' => 20000, 'C3' => 4.6, 'C4' => 5],
            ],
            [
                'nama_wisata' => 'Small World (Taman Miniatur Dunia)',
                'deskripsi' => 'Taman rekreasi edukatif yang menampilkan miniatur ikon-ikon terkenal di dunia.',
                'kategori' => 'Buatan',
                'latitude' => -7.33230, 'longitude' => 109.22442,
                'penilaian' => ['C2' => 20000, 'C3' => 4.2, 'C4' => 5],
            ],
            [
                'nama_wisata' => 'Taman Andhang Pangrenan',
                'deskripsi' => 'Ruang terbuka hijau di tengah kota Purwokerto, cocok untuk wisata keluarga.',
                'kategori' => 'Buatan',
                'latitude' => -7.44044, 'longitude' => 109.24374,
                'penilaian' => ['C2' => 5000, 'C3' => 4.3, 'C4' => 5],
            ],
            [
                'nama_wisata' => 'Dreamland Waterpark Ajibarang',
                'deskripsi' => 'Taman bermain air terbesar di wilayah Banyumas barat.',
                'kategori' => 'Buatan',
                'latitude' => -7.42283, 'longitude' => 109.07523,
                'penilaian' => ['C2' => 25000, 'C3' => 4.0, 'C4' => 6], // Tiket mahal tapi fasilitas lengkap
            ],
            [
                'nama_wisata' => 'Bendung Gerak Serayu',
                'deskripsi' => 'Bendungan raksasa di Sungai Serayu yang menawarkan pemandangan asri.',
                'kategori' => 'Buatan',
                'latitude' => -7.52549, 'longitude' => 109.20123,
                'penilaian' => ['C2' => 0, 'C3' => 4.3, 'C4' => 3], // Gratis (0)
            ],

            // Kategori budaya dan sejarah
            [
                'nama_wisata' => 'Museum Panglima Besar Sudirman',
                'deskripsi' => 'Museum sejarah perjuangan Jenderal Sudirman yang berada di Karanglewas.',
                'kategori' => 'Budaya',
                'latitude' => -7.41958, 'longitude' => 109.19623,
                'penilaian' => ['C2' => 5000, 'C3' => 4.5, 'C4' => 4],
            ],
            [
                'nama_wisata' => 'Masjid Saka Tunggal',
                'deskripsi' => 'Masjid tertua di Indonesia yang dibangun pada tahun 1288, dengan ciri khas satu tiang.',
                'kategori' => 'Budaya',
                'latitude' => -7.58682, 'longitude' => 109.51933,
                'penilaian' => ['C2' => 5000, 'C3' => 4.5, 'C4' => 3],
            ],
            [
                'nama_wisata' => 'Museum Wayang Banyumas',
                'deskripsi' => 'Museum edukasi budaya yang menyimpan koleksi berbagai jenis wayang Nusantara.',
                'kategori' => 'Budaya',
                'latitude' => -7.51461, 'longitude' => 109.29425, // Area Kota Lama Banyumas
                'penilaian' => ['C2' => 2000, 'C3' => 4.5, 'C4' => 4],
            ],
        ];

        // Tarik ID kriteria dari tabel kriterias
        $c2 = Kriteria::where('kode', 'C2')->first();
        $c3 = Kriteria::where('kode', 'C3')->first();
        $c4 = Kriteria::where('kode', 'C4')->first();

        // Cek jika kriteria belum di-seed
        if (! $c2 || ! $c3 || ! $c4) {
            $this->command->error('Kriteria C2, C3, atau C4 tidak ditemukan! Jalankan KriteriaSeeder terlebih dahulu.');

            return;
        }

        foreach ($wisatas as $w) {
            $wisata = Wisata::create([
                'nama_wisata' => $w['nama_wisata'],
                'deskripsi' => $w['deskripsi'],
                'kategori' => $w['kategori'],
                'latitude' => $w['latitude'],
                'longitude' => $w['longitude'],
            ]);

            // Insert ke tabel pivot
            Penilaian::create(['wisata_id' => $wisata->id, 'kriteria_id' => $c2->id, 'nilai' => $w['penilaian']['C2']]);
            Penilaian::create(['wisata_id' => $wisata->id, 'kriteria_id' => $c3->id, 'nilai' => $w['penilaian']['C3']]);
            Penilaian::create(['wisata_id' => $wisata->id, 'kriteria_id' => $c4->id, 'nilai' => $w['penilaian']['C4']]);
        }
    }
}
