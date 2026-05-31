<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Riwayat Analisis TOPSIS') }}
        </h2>
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
                    
                    <!-- Meta Info & Tab Navigation -->
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div>
                            <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Hasil Analisis Terakhir</span>
                            <h3 class="text-lg font-bold text-slate-800">Nama: {{ $nama }} (Minat: Wisata {{ $kategori }})</h3>
                            <p class="text-slate-400 text-xs mt-1">Metode: TOPSIS Murni (Decison Support System)</p>
                        </div>
                        
                        <!-- Navigation Tab Buttons -->
                        <div class="flex flex-wrap gap-1 bg-slate-100 p-1 rounded-xl">
                            <button @click="tab = 'ringkasan'" 
                                    :class="tab === 'ringkasan' ? 'bg-white text-emerald-700 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                                    class="px-4 py-2 text-xs font-bold rounded-lg transition duration-200">
                                📊 Ringkasan & Hasil
                            </button>
                            <button @click="tab = 'matriks-x-r'" 
                                    :class="tab === 'matriks-x-r' ? 'bg-white text-emerald-700 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                                    class="px-4 py-2 text-xs font-bold rounded-lg transition duration-200">
                                🔢 Matriks X & R
                            </button>
                            <button @click="tab = 'matriks-y'" 
                                    :class="tab === 'matriks-y' ? 'bg-white text-emerald-700 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                                    class="px-4 py-2 text-xs font-bold rounded-lg transition duration-200">
                                ⚖️ Matriks Terbobot (Y)
                            </button>
                            <button @click="tab = 'solusi-ideal'" 
                                    :class="tab === 'solusi-ideal' ? 'bg-white text-emerald-700 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                                    class="px-4 py-2 text-xs font-bold rounded-lg transition duration-200">
                                🏁 Solusi Ideal & Jarak
                            </button>
                        </div>
                    </div>

                    <!-- TAB CONTENTS -->

                    <!-- 1. Ringkasan & Hasil Akhir -->
                    <div x-show="tab === 'ringkasan'" class="space-y-6">
                        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                            <h4 class="text-lg font-bold text-slate-800 mb-4">Hasil Perankingan Teratas (Top 5)</h4>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="border-b border-slate-100 bg-slate-50/50">
                                            <th class="py-3.5 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider w-16">Rank</th>
                                            <th class="py-3.5 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Alternatif</th>
                                            <th class="py-3.5 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Kategori</th>
                                            <th class="py-3.5 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Jarak Rute (C1)</th>
                                            <th class="py-3.5 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Nilai Preferensi (V)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-sm">
                                        @foreach(array_slice($preferensi, 0, 5) as $index => $item)
                                            @php
                                                $wisata = (object) $item['wisata'];
                                            @endphp
                                            <tr class="{{ $index === 0 ? 'bg-emerald-50/30' : '' }} hover:bg-slate-50/50 transition">
                                                <td class="py-4 px-4 font-extrabold text-slate-800">
                                                    @if($index === 0)
                                                        👑 #1
                                                    @else
                                                        #{{ $index + 1 }}
                                                    @endif
                                                </td>
                                                <td class="py-4 px-4 font-bold text-slate-800">{{ $wisata->nama_wisata }}</td>
                                                <td class="py-4 px-4 text-slate-500">{{ $wisata->kategori }}</td>
                                                <td class="py-4 px-4 text-center font-semibold text-slate-600">{{ $item['jarak_km'] }} km</td>
                                                <td class="py-4 px-4 text-right font-black text-emerald-700 text-lg">{{ $item['nilai_v'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Matriks Keputusan X & Matriks Normalisasi R -->
                    <div x-show="tab === 'matriks-x-r'" class="space-y-8">
                        <!-- Matriks Keputusan Awal (X) -->
                        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                            <h4 class="text-lg font-bold text-slate-800 mb-1">Matriks Keputusan Awal (X)</h4>
                            <p class="text-slate-400 text-xs mb-4">Nilai riil dari alternatif wisata pada setiap kriteria (C1 didapat dari rute berkendara riil).</p>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="border-b border-slate-100 bg-slate-50/50">
                                            <th class="py-3.5 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Alternatif Wisata</th>
                                            @foreach($kriterias as $k)
                                                <th class="py-3.5 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">
                                                    {{ $k->nama_kriteria }} ({{ $k->kode }}) <br>
                                                    <span class="text-[10px] font-normal text-slate-400 lowercase">type: {{ $k->tipe }}</span>
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-sm">
                                        @foreach($wisatas as $w)
                                            @php
                                                $wisata = (object) $w;
                                            @endphp
                                            <tr class="hover:bg-slate-50/50 transition">
                                                <td class="py-3.5 px-4 font-bold text-slate-800">{{ $wisata->nama_wisata }}</td>
                                                <td class="py-3.5 px-4 text-center text-slate-600 font-mono">{{ $matriksX[$wisata->id]['C1'] }} km</td>
                                                <td class="py-3.5 px-4 text-center text-slate-600 font-mono">Rp {{ number_format($matriksX[$wisata->id]['C2'] ?? 0, 0, ',', '.') }}</td>
                                                <td class="py-3.5 px-4 text-center text-slate-600 font-mono">⭐ {{ $matriksX[$wisata->id]['C3'] ?? 0 }}</td>
                                                <td class="py-3.5 px-4 text-center text-slate-600 font-mono">{{ $matriksX[$wisata->id]['C4'] ?? 0 }} Poin</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Matriks Normalisasi (R) -->
                        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                            <h4 class="text-lg font-bold text-slate-800 mb-1">Matriks Normalisasi (R)</h4>
                            <p class="text-slate-400 text-xs mb-4">Membagi nilai matriks keputusan awal dengan akar kuadrat jumlah nilai seluruh alternatif per kriteria.</p>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="border-b border-slate-100 bg-slate-50/50">
                                            <th class="py-3.5 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Alternatif Wisata</th>
                                            @foreach($kriterias as $k)
                                                <th class="py-3.5 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">{{ $k->kode }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-sm">
                                        @foreach($wisatas as $w)
                                            @php
                                                $wisata = (object) $w;
                                            @endphp
                                            <tr class="hover:bg-slate-50/50 transition">
                                                <td class="py-3.5 px-4 font-bold text-slate-800">{{ $wisata->nama_wisata }}</td>
                                                @foreach($kriterias as $k)
                                                    <td class="py-3.5 px-4 text-center font-mono text-slate-700">
                                                        {{ round($matriksR[$wisata->id][$k->kode], 5) }}
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
                        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                            <h4 class="text-lg font-bold text-slate-800 mb-1">Matriks Ternormalisasi Terbobot (Y)</h4>
                            <p class="text-slate-400 text-xs mb-4">Mengalikan kolom matriks normalisasi (R) dengan bobot kriteria masing-masing.</p>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="border-b border-slate-100 bg-slate-50/50">
                                            <th class="py-3.5 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Alternatif Wisata</th>
                                            @foreach($kriterias as $k)
                                                <th class="py-3.5 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">
                                                    {{ $k->kode }} <br>
                                                    <span class="text-[10px] font-normal text-slate-400">bobot: {{ $k->bobot }}</span>
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-sm">
                                        @foreach($wisatas as $w)
                                            @php
                                                $wisata = (object) $w;
                                            @endphp
                                            <tr class="hover:bg-slate-50/50 transition">
                                                <td class="py-3.5 px-4 font-bold text-slate-800">{{ $wisata->nama_wisata }}</td>
                                                @foreach($kriterias as $k)
                                                    <td class="py-3.5 px-4 text-center font-mono font-semibold text-slate-700">
                                                        {{ round($matriksY[$wisata->id][$k->kode], 5) }}
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
                    <div x-show="tab === 'solusi-ideal'" class="space-y-8">
                        <!-- Solusi Ideal Positif & Negatif -->
                        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                            <h4 class="text-lg font-bold text-slate-800 mb-1">Solusi Ideal Positif (A+) & Negatif (A-)</h4>
                            <p class="text-slate-400 text-xs mb-4">Mencari nilai maksimum untuk kriteria Benefit dan nilai minimum untuk kriteria Cost (dan sebaliknya).</p>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="border-b border-slate-100 bg-slate-50/50">
                                            <th class="py-3.5 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Solusi Ideal</th>
                                            @foreach($kriterias as $k)
                                                <th class="py-3.5 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">{{ $k->kode }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-sm">
                                        <tr class="bg-emerald-50/20">
                                            <td class="py-4 px-4 font-bold text-emerald-800">Positif (A+)</td>
                                            @foreach($kriterias as $k)
                                                <td class="py-4 px-4 text-center font-mono font-bold text-emerald-700">
                                                    {{ round($A_plus[$k->kode], 5) }}
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr class="bg-rose-50/20">
                                            <td class="py-4 px-4 font-bold text-rose-800">Negatif (A-)</td>
                                            @foreach($kriterias as $k)
                                                <td class="py-4 px-4 text-center font-mono font-bold text-rose-700">
                                                    {{ round($A_min[$k->kode], 5) }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Jarak Alternatif ke Solusi Ideal -->
                        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                            <h4 class="text-lg font-bold text-slate-800 mb-1">Jarak Alternatif ke Solusi Ideal (D+ & D-)</h4>
                            <p class="text-slate-400 text-xs mb-4">Menghitung jarak Euclidean setiap alternatif ke solusi ideal positif (D+) dan solusi ideal negatif (D-).</p>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="border-b border-slate-100 bg-slate-50/50">
                                            <th class="py-3.5 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Alternatif Wisata</th>
                                            <th class="py-3.5 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Jarak ke Ideal Positif (D+)</th>
                                            <th class="py-3.5 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Jarak ke Ideal Negatif (D-)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-sm">
                                        @foreach($wisatas as $w)
                                            @php
                                                $wisata = (object) $w;
                                            @endphp
                                            <tr class="hover:bg-slate-50/50 transition">
                                                <td class="py-3.5 px-4 font-bold text-slate-800">{{ $wisata->nama_wisata }}</td>
                                                <td class="py-3.5 px-4 text-center font-mono text-emerald-600 font-semibold">{{ round($D_plus[$wisata->id], 5) }}</td>
                                                <td class="py-3.5 px-4 text-center font-mono text-rose-600 font-semibold">{{ round($D_min[$wisata->id], 5) }}</td>
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
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-12 text-center max-w-2xl mx-auto">
                    <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6 text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-3">Belum Ada Perhitungan</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-8">
                        Anda belum menjalankan proses pencarian rekomendasi wisata di sistem kami. Jalankan pencarian di beranda terlebih dahulu untuk melihat visualisasi langkah perhitungan TOPSIS di halaman ini.
                    </p>
                    <a href="{{ url('/#rekomendasi') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-8 py-3.5 rounded-xl transition shadow-md shadow-emerald-200">
                        Mulai Cari Rekomendasi
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
