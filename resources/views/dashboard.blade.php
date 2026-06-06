<x-app-layout title="Hasil Analisis & Perhitungan TOPSIS">
    <!-- Header Block -->
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Hasil Analisis Rekomendasi') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Langkah demi langkah perhitungan matematis metode TOPSIS</p>
            </div>
            <span class="bg-emerald-50 text-[#457C1A] text-xs font-extrabold px-4 py-1.5 rounded-full uppercase tracking-wider">
                Status: Teranalisis
            </span>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(isset($lastTopsis))
                @php
                    $nama = $lastTopsis['nama'];
                    $kategori = $lastTopsis['kategori'];
                    $data = $lastTopsis['data'];
                    
                    $kriterias = $data['kriterias'];
                    $wisatas = $data['wisatas'];
                    $matriksX = $data['matriksX'];
                    $matriksR = $data['matriksR'];
                    $matriksY = $data['matriksY'];
                    $A_plus = $data['A_plus'];
                    $A_min = $data['A_min'];
                    $D_plus = $data['D_plus'];
                    $D_min = $data['D_min'];
                    $preferensi = $data['preferensi'];
                @endphp

                <div class="space-y-8" x-data="{ tab: 'ringkasan' }">
                    
                    <!-- Welcome Header & Tab Nav -->
                    <div class="bg-gradient-to-r from-slate-900 via-emerald-950 to-[#457C1A] rounded-[2rem] shadow-xl p-6 md:p-8 text-white relative overflow-hidden">
                        <div class="absolute inset-0 z-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                        
                        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                            <div>
                                <span class="bg-[#457C1A] text-white text-[10px] font-extrabold px-3 py-1 rounded-md uppercase tracking-wider">
                                    Hasil Analisis Terakhir
                                </span>
                                <h3 class="text-2xl font-black mt-3">Untuk: {{ $nama }}</h3>
                                <p class="text-white/80 text-sm mt-1">
                                    Minat Pariwisata: <strong class="text-white">Wisata {{ $kategori }}</strong> | Metode: TOPSIS (Jarak C1 dihitung otomatis)
                                </p>
                            </div>

                            <!-- Tabs Switcher -->
                            <div class="flex flex-wrap gap-1.5 bg-black/30 p-1.5 rounded-2xl shrink-0 backdrop-blur-sm border border-white/5">
                                <button @click="tab = 'ringkasan'" 
                                        :class="tab === 'ringkasan' ? 'bg-white text-[#457C1A] shadow-md' : 'text-white/80 hover:text-white hover:bg-white/10'"
                                        class="px-4 py-2.5 text-xs font-bold rounded-xl transition duration-300">
                                    Ringkasan
                                </button>
                                <button @click="tab = 'matriks-x-r'" 
                                        :class="tab === 'matriks-x-r' ? 'bg-white text-[#457C1A] shadow-md' : 'text-white/80 hover:text-white hover:bg-white/10'"
                                        class="px-4 py-2.5 text-xs font-bold rounded-xl transition duration-300">
                                    Matriks X & R
                                </button>
                                <button @click="tab = 'matriks-y'" 
                                        :class="tab === 'matriks-y' ? 'bg-white text-[#457C1A] shadow-md' : 'text-white/80 hover:text-white hover:bg-white/10'"
                                        class="px-4 py-2.5 text-xs font-bold rounded-xl transition duration-300">
                                    Matriks Y
                                </button>
                                <button @click="tab = 'solusi-ideal'" 
                                        :class="tab === 'solusi-ideal' ? 'bg-white text-[#457C1A] shadow-md' : 'text-white/80 hover:text-white hover:bg-white/10'"
                                        class="px-4 py-2.5 text-xs font-bold rounded-xl transition duration-300">
                                    Solusi & Jarak
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- TAB CONTENT PANELS -->

                    <!-- 1. Ringkasan & Rekomendasi Teratas -->
                    <div x-show="tab === 'ringkasan'" class="space-y-6">
                        <div class="bg-white rounded-[2rem] border border-slate-100 p-6 md:p-8 shadow-sm">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#457C1A] flex items-center justify-center font-bold">👑</div>
                                <h4 class="text-lg font-black text-slate-800">Rekomendasi Destinasi Wisata Teratas</h4>
                            </div>

                            <div class="overflow-x-auto rounded-2xl border border-slate-100">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-slate-50/70 border-b border-slate-100">
                                            <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider w-20">Rank</th>
                                            <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Alternatif Wisata</th>
                                            <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Kategori</th>
                                            <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Jarak Nyata (C1)</th>
                                            <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Nilai Preferensi (V)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                                        @foreach($preferensi as $index => $item)
                                            @php
                                                $wisata = (object) $item['wisata'];
                                            @endphp
                                            <tr class="{{ $index === 0 ? 'bg-emerald-50/20 font-semibold' : '' }} hover:bg-slate-50/50 transition">
                                                <td class="py-4 px-6">
                                                    @if($index === 0)
                                                        <span class=>#1 Terbaik</span>
                                                    @else
                                                        <span class="text-slate-400 font-bold">#{{ $index + 1 }}</span>
                                                    @endif
                                                </td>
                                                <td class="py-4 px-6 font-bold text-slate-800">
                                                    {{ $wisata->nama_wisata }}
                                                </td>
                                                <td class="py-4 px-6">
                                                    @if ($wisata->kategori === 'Alam')
                                                        <span class="bg-emerald-50 text-[#457C1A] text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">Alam</span>
                                                    @elseif ($wisata->kategori === 'Buatan')
                                                        <span class="bg-sky-50 text-sky-700 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">Buatan</span>
                                                    @else
                                                        <span class="bg-amber-50 text-amber-700 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">Budaya</span>
                                                    @endif
                                                </td>
                                                <td class="py-4 px-6 text-center font-mono text-slate-600 font-semibold">
                                                    {{ $item['jarak_km'] }} km
                                                </td>
                                                <td class="py-4 px-6 text-right text-lg font-black text-[#457C1A] font-mono">
                                                    {{ number_format($item['nilai_v'], 4) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Matriks X & R -->
                    <div x-show="tab === 'matriks-x-r'" class="space-y-6">
                        <!-- Matriks Keputusan Riil (X) -->
                        <div class="bg-white rounded-[2rem] border border-slate-100 p-6 md:p-8 shadow-sm">
                            <div class="mb-4">
                                <h4 class="text-lg font-black text-slate-800">Matriks Keputusan Awal (X)</h4>
                                <p class="text-slate-400 text-xs mt-0.5">Nilai riil performa alternatif wisata berdasarkan kriteria keputusan (C1 s.d C4).</p>
                            </div>
                            <div class="overflow-x-auto rounded-2xl border border-slate-100">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-slate-50/70 border-b border-slate-100">
                                            <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Alternatif Wisata</th>
                                            @foreach($kriterias as $k)
                                                <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">
                                                    {{ $k->nama_kriteria }} ({{ $k->kode }})<br>
                                                    <span class="text-[9px] font-normal text-slate-400 normal-case">Tipe: {{ ucfirst($k->tipe) }}</span>
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600 font-mono">
                                        @foreach($wisatas as $w)
                                            @php
                                                $wisata = (object) $w;
                                            @endphp
                                            <tr class="hover:bg-slate-50/50 transition">
                                                <td class="py-3.5 px-6 font-sans font-bold text-slate-800">{{ $wisata->nama_wisata }}</td>
                                                <td class="py-3.5 px-6 text-center font-semibold text-slate-600">{{ $matriksX[$wisata->id]['C1'] }} km</td>
                                                <td class="py-3.5 px-6 text-center font-semibold text-slate-600">Rp {{ number_format($matriksX[$wisata->id]['C2'] ?? 0, 0, ',', '.') }}</td>
                                                <td class="py-3.5 px-6 text-center font-semibold text-slate-600">⭐ {{ number_format($matriksX[$wisata->id]['C3'] ?? 0, 1) }}</td>
                                                <td class="py-3.5 px-6 text-center font-semibold text-slate-600">{{ intval($matriksX[$wisata->id]['C4'] ?? 0) }} Poin</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Matriks Normalisasi (R) -->
                        <div class="bg-white rounded-[2rem] border border-slate-100 p-6 md:p-8 shadow-sm">
                            <div class="mb-4">
                                <h4 class="text-lg font-black text-slate-800">Matriks Normalisasi (R)</h4>
                                <p class="text-slate-400 text-xs mt-0.5">Nilai matriks riil terdistribusi merata dengan membagi nilai awal dengan jumlah kuadrat seluruh alternatif.</p>
                            </div>
                            <div class="overflow-x-auto rounded-2xl border border-slate-100">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-slate-50/70 border-b border-slate-100">
                                            <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Alternatif Wisata</th>
                                            @foreach($kriterias as $k)
                                                <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">{{ $k->kode }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600 font-mono">
                                        @foreach($wisatas as $w)
                                            @php
                                                $wisata = (object) $w;
                                            @endphp
                                            <tr class="hover:bg-slate-50/50 transition">
                                                <td class="py-3.5 px-6 font-sans font-bold text-slate-800">{{ $wisata->nama_wisata }}</td>
                                                @foreach($kriterias as $k)
                                                    <td class="py-3.5 px-6 text-center font-semibold text-slate-700">
                                                        {{ number_format($matriksR[$wisata->id][$k->kode], 5) }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Matriks Ternormalisasi Terbobot (Y) -->
                    <div x-show="tab === 'matriks-y'" class="space-y-6">
                        <div class="bg-white rounded-[2rem] border border-slate-100 p-6 md:p-8 shadow-sm">
                            <div class="mb-4">
                                <h4 class="text-lg font-black text-slate-800">Matriks Ternormalisasi Terbobot (Y)</h4>
                                <p class="text-slate-400 text-xs mt-0.5">Nilai ternormalisasi terdistorsi dengan bobot kepentingan masing-masing kriteria.</p>
                            </div>
                            <div class="overflow-x-auto rounded-2xl border border-slate-100">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-slate-50/70 border-b border-slate-100">
                                            <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Alternatif Wisata</th>
                                            @foreach($kriterias as $k)
                                                <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">
                                                    {{ $k->kode }}<br>
                                                    <span class="text-[9px] font-normal text-slate-400">Bobot: {{ $k->bobot }}</span>
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600 font-mono">
                                        @foreach($wisatas as $w)
                                            @php
                                                $wisata = (object) $w;
                                            @endphp
                                            <tr class="hover:bg-slate-50/50 transition">
                                                <td class="py-3.5 px-6 font-sans font-bold text-slate-800">{{ $wisata->nama_wisata }}</td>
                                                @foreach($kriterias as $k)
                                                    <td class="py-3.5 px-6 text-center font-bold text-[#457C1A]">
                                                        {{ number_format($matriksY[$wisata->id][$k->kode], 5) }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Solusi Ideal & Jarak -->
                    <div x-show="tab === 'solusi-ideal'" class="space-y-6">
                        <!-- Solusi Ideal Positif & Negatif -->
                        <div class="bg-white rounded-[2rem] border border-slate-100 p-6 md:p-8 shadow-sm">
                            <div class="mb-4">
                                <h4 class="text-lg font-black text-slate-800">Solusi Ideal Positif (A+) & Negatif (A-)</h4>
                                <p class="text-slate-400 text-xs mt-0.5">Penentuan titik acuan solusi pariwisata terbaik (A+) dan terburuk (A-).</p>
                            </div>
                            <div class="overflow-x-auto rounded-2xl border border-slate-100">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-slate-50/70 border-b border-slate-100">
                                            <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Solusi Ideal</th>
                                            @foreach($kriterias as $k)
                                                <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">{{ $k->kode }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-sm font-mono">
                                        <tr class="bg-emerald-50/30">
                                            <td class="py-4 px-6 font-sans font-extrabold text-[#457C1A]">Positif (A+)</td>
                                            @foreach($kriterias as $k)
                                                <td class="py-4 px-6 text-center font-bold text-[#457C1A]">
                                                    {{ number_format($A_plus[$k->kode], 5) }}
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr class="bg-rose-50/30">
                                            <td class="py-4 px-6 font-sans font-extrabold text-rose-800">Negatif (A-)</td>
                                            @foreach($kriterias as $k)
                                                <td class="py-4 px-6 text-center font-bold text-rose-700">
                                                    {{ number_format($A_min[$k->kode], 5) }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Jarak Alternatif -->
                        <div class="bg-white rounded-[2rem] border border-slate-100 p-6 md:p-8 shadow-sm">
                            <div class="mb-4">
                                <h4 class="text-lg font-black text-slate-800">Jarak Euclidean Alternatif (D+ & D-)</h4>
                                <p class="text-slate-400 text-xs mt-0.5">Pengukuran kedekatan geometris setiap destinasi pariwisata terhadap solusi ideal.</p>
                            </div>
                            <div class="overflow-x-auto rounded-2xl border border-slate-100">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-slate-50/70 border-b border-slate-100">
                                            <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Alternatif Wisata</th>
                                            <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Jarak ke Ideal Positif (D+)</th>
                                            <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Jarak ke Ideal Negatif (D-)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600 font-mono">
                                        @foreach($wisatas as $w)
                                            @php
                                                $wisata = (object) $w;
                                            @endphp
                                            <tr class="hover:bg-slate-50/50 transition">
                                                <td class="py-3.5 px-6 font-sans font-bold text-slate-800">{{ $wisata->nama_wisata }}</td>
                                                <td class="py-3.5 px-6 text-center text-[#457C1A] font-bold">{{ number_format($D_plus[$wisata->id], 5) }}</td>
                                                <td class="py-3.5 px-6 text-center text-rose-600 font-bold">{{ number_format($D_min[$wisata->id], 5) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            @else
                <!-- EMPTY STATE -->
                <div class="bg-white rounded-tr-[5rem] rounded-bl-[5rem] rounded-tl-[1.5rem] rounded-br-[1.5rem] border border-slate-100 shadow-xl p-10 sm:p-14 text-center max-w-2xl mx-auto">
                    <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6 text-[#457C1A]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-3">Belum Ada Analisis Terjalin</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-8">
                        Anda belum menjalankan formulir kalkulator pencarian rekomendasi wisata di sistem kami. Jalankan proses pencarian di Beranda untuk memicu perhitungan matematis TOPSIS.
                    </p>
                    <a href="{{ url('/#rekomendasi') }}" class="bg-[#457C1A] hover:bg-[#2d5211] text-white font-bold text-sm px-8 py-3.5 rounded-full transition shadow-md shadow-[#457C1A]/20 inline-block">
                        Mulai Cari Rekomendasi
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
