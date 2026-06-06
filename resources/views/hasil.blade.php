<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hasil Rekomendasi Wisata</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-800 min-h-screen pb-20">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto" />
                <span class="font-bold text-xl tracking-tight text-emerald-900 hidden sm:inline">BanyumasExplore</span>
            </div>
            <a href="/" class="text-slate-500 hover:text-emerald-600 font-medium transition">Kembali ke Beranda</a>
        </div>
    </nav>

    <div class="bg-emerald-900 pt-16 pb-32 relative overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="max-w-5xl mx-auto px-4 relative z-10 text-center">
            <span class="bg-emerald-800 text-emerald-200 text-sm font-bold px-4 py-1.5 rounded-full uppercase tracking-wider">Hasil Analisis SPK TOPSIS</span>
            <h1 class="text-3xl md:text-5xl font-extrabold text-white mt-6 mb-4">Rekomendasi Terbaik untuk Anda</h1>
            <p class="text-emerald-100 text-lg">Halo <b>{{ $namaWisatawan }}</b>, berdasarkan kalkulasi jarak dan preferensi <b>Wisata {{ $kategori }}</b>, berikut adalah daftar destinasi wisata terurut dari rekomendasi terbaik pilihan sistem.</p>
            <div class="mt-6 flex justify-center">
                <a href="{{ route('dashboard') }}" class="bg-amber-500 hover:bg-amber-600 text-slate-900 text-sm font-extrabold px-6 py-3 rounded-full shadow-lg transition">
                    Proses Perhitungan
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 -mt-20 relative z-20">
        <div class="flex flex-col gap-6">
            
            @forelse($hasil as $index => $item)
                @php
                    $wisata = $item['wisata'];
                    // Tarik nilai matriks untuk ditampilkan (C2, C3, C4)
                    $harga = $wisata->penilaian->where('kriteria_id', 2)->first()->nilai ?? 0;
                    $rating = $wisata->penilaian->where('kriteria_id', 3)->first()->nilai ?? 0;
                    $fasilitas = $wisata->penilaian->where('kriteria_id', 4)->first()->nilai ?? 0;
                @endphp

                <div class="bg-white rounded-2xl shadow-md border border-slate-100 p-6 md:p-8 flex flex-col md:flex-row gap-6 items-center hover:shadow-xl transition-all relative overflow-hidden">
                    
                    <div class="absolute top-0 left-0 w-16 h-16 bg-emerald-100 rounded-br-full flex items-start justify-start pt-3 pl-4">
                        <span class="text-2xl font-black text-emerald-700">#{{ $index + 1 }}</span>
                    </div>

                    <div class="flex-1 pt-12 md:pt-0 pl-0 md:pl-10">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ $wisata->kategori }}</span>
                        <h2 class="text-2xl font-bold text-slate-800 mb-2">{{ $wisata->nama_wisata }}</h2>
                        <p class="text-slate-600 mb-4 line-clamp-2">{{ $wisata->deskripsi }}</p>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <div>
                                <span class="block text-xs text-slate-500 mb-1">C1 (Jarak)</span>
                                <span class="font-bold text-slate-700">{{ $item['jarak_km'] }} km</span>
                            </div>
                            <div>
                                <span class="block text-xs text-slate-500 mb-1">C2 (Harga)</span>
                                <span class="font-bold text-slate-700">Rp {{ number_format($harga, 0, ',', '.') }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-slate-500 mb-1">C3 (Rating)</span>
                                <span class="font-bold text-slate-700">⭐ {{ $rating }} / 5.0</span>
                            </div>
                            <div>
                                <span class="block text-xs text-slate-500 mb-1">C4 (Fasilitas)</span>
                                <span class="font-bold text-slate-700">{{ $fasilitas }} Poin</span>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-48 bg-emerald-50 rounded-xl p-6 text-center border border-emerald-100 shrink-0">
                        <span class="block text-xs font-bold text-emerald-600 uppercase mb-2">Nilai Preferensi (V)</span>
                        <span class="text-4xl font-black text-emerald-700">{{ $item['nilai_v'] }}</span>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $wisata->latitude }},{{ $wisata->longitude }}" target="_blank" class="mt-4 block w-full bg-slate-800 text-white text-sm font-medium py-2 rounded-lg hover:bg-slate-700 transition">
                            Lihat di Maps
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow-md p-12 text-center border border-slate-100">
                    <div class="text-5xl mb-4">🏜️</div>
                    <h3 class="text-xl font-bold text-slate-800">Tidak ada wisata di kategori ini</h3>
                    <p class="text-slate-500 mt-2">Silakan kembali dan pilih kategori yang berbeda.</p>
                    <a href="/" class="inline-block mt-6 bg-emerald-600 text-white px-6 py-2 rounded-lg hover:bg-emerald-700 transition">Cari Ulang</a>
                </div>
            @endforelse

        </div>

        <div class="mt-12 text-center">
            <a href="/" class="text-emerald-600 font-bold hover:text-emerald-700 transition flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fillRule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clipRule="evenodd" />
                </svg>
                Kembali ke Pencarian
            </a>
        </div>
    </div>

</body>
</html>