<x-app-layout title="Kelola Matriks Penilaian SPK">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Kelola Matriks Penilaian') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Isi nilai performa alternatif destinasi wisata terhadap kriteria utama</p>
            </div>
            <span class="bg-indigo-50 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">
                Matrix Editor
            </span>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Success Alert -->
            @if (session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl shadow-sm flex items-center justify-between" role="alert">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-semibold">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Info Box -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex gap-4 items-start">
                <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-sm">Panduan Pengisian Skala Penilaian</h3>
                    <p class="text-slate-500 text-xs mt-1.5 leading-relaxed">
                        <strong>C2 (Harga Tiket):</strong> Masukkan nominal Rupiah tiket masuk (Gunakan angka saja, misal 15000. Masukkan 0 jika wisata gratis).<br>
                        <strong>C3 (Rating):</strong> Masukkan nilai rating desimal (Skala 1.0 sampai 5.0, contoh: 4.5).<br>
                        <strong>C4 (Fasilitas):</strong> Skala poin kelengkapan fasilitas pariwisata (Rentang 1 sampai 5. 1 = Sangat Kurang, 5 = Sangat Lengkap).
                    </p>
                </div>
            </div>

            <!-- Search Filter -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <form action="{{ route('admin.penilaian.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ $search }}" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm placeholder:text-slate-400 text-slate-700 transition" placeholder="Cari destinasi untuk dinilai...">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold px-6 py-2.5 rounded-xl text-sm transition shrink-0">
                            Filter
                        </button>
                        @if ($search)
                            <a href="{{ route('admin.penilaian.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold px-4 py-2.5 rounded-xl text-sm transition shrink-0 flex items-center justify-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Matrix Form Table -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <form action="{{ route('admin.penilaian.update') }}" method="POST" class="p-6">
                    @csrf
                    
                    <div class="overflow-x-auto rounded-2xl border border-slate-100">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    <th class="py-4 px-6">Alternatif Wisata</th>
                                    @foreach ($kriterias as $kriteria)
                                        <th class="py-4 px-6 w-52">
                                            <div class="flex flex-col">
                                                <span>{{ $kriteria->nama_kriteria }}</span>
                                                <span class="text-[10px] text-slate-400 normal-case font-medium mt-0.5">
                                                    {{ $kriteria->kode }} ({{ ucfirst($kriteria->tipe) }})
                                                </span>
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                                @forelse ($wisatas as $wisata)
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <!-- Wisata Info -->
                                        <td class="py-4 px-6 flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg overflow-hidden border border-slate-100 shadow-sm shrink-0 bg-slate-100">
                                                <img src="{{ $wisata->foto ? asset('storage/' . $wisata->foto) : 'https://images.unsplash.com/photo-1596401057633-54a8fe8ef647?q=80&w=600&auto=format&fit=crop' }}" class="w-full h-full object-cover" alt="{{ $wisata->nama_wisata }}">
                                            </div>
                                            <div>
                                                <span class="font-bold text-slate-800 block leading-snug">{{ $wisata->nama_wisata }}</span>
                                                <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md mt-1 inline-block uppercase tracking-wider">{{ $wisata->kategori }}</span>
                                            </div>
                                        </td>
                                        
                                        <!-- Kriterias (C2, C3, C4) -->
                                        @foreach ($kriterias as $k)
                                            <td class="py-4 px-6">
                                                @php
                                                    $currentVal = isset($wisata->mapped_penilaian[$k->id]) ? $wisata->mapped_penilaian[$k->id] : 0;
                                                @endphp

                                                @if ($k->kode === 'C2')
                                                    <!-- Harga Tiket (C2) -->
                                                    <div class="relative rounded-xl shadow-sm">
                                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                            <span class="text-slate-400 text-xs font-semibold">Rp</span>
                                                        </div>
                                                        <input type="number" min="0" name="penilaian[{{ $wisata->id }}][{{ $k->id }}]" value="{{ intval($currentVal) }}" class="w-full pl-9 pr-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-xs font-mono text-slate-800 transition" placeholder="0" required>
                                                    </div>
                                                @elseif ($k->kode === 'C3')
                                                    <!-- Rating (C3) -->
                                                    <div class="relative rounded-xl shadow-sm">
                                                        <input type="number" step="0.1" min="1.0" max="5.0" name="penilaian[{{ $wisata->id }}][{{ $k->id }}]" value="{{ number_format($currentVal, 1) }}" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-xs font-mono text-slate-800 transition" placeholder="1.0 - 5.0" required>
                                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                                            <span class="text-amber-400 font-bold text-xs">★</span>
                                                        </div>
                                                    </div>
                                                @elseif ($k->kode === 'C4')
                                                    <!-- Fasilitas (C4) -->
                                                    <select name="penilaian[{{ $wisata->id }}][{{ $k->id }}]" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-xs text-slate-800 transition bg-white" required>
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <option value="{{ $i }}" {{ intval($currentVal) === $i ? 'selected' : '' }}>
                                                                {{ $i }} ({{ ['Sangat Kurang', 'Kurang', 'Cukup', 'Lengkap', 'Sangat Lengkap'][$i-1] }})
                                                            </option>
                                                        @endfor
                                                    </select>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-10 text-center text-slate-400">
                                            Tidak ada destinasi wisata yang dapat dinilai.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($wisatas->hasPages())
                        <div class="py-4 mt-2">
                            {{ $wisatas->appends(['search' => $search])->links() }}
                        </div>
                    @endif

                    <!-- Submit Buttons -->
                    <div class="border-t border-slate-100 pt-6 flex justify-end gap-3 mt-4">
                        <a href="{{ route('admin.dashboard') }}" class="px-6 py-2.5 rounded-full border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-sm transition">
                            Batal
                        </a>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-2.5 rounded-full text-sm transition duration-300 shadow-md shadow-emerald-600/20">
                            Simpan Matriks
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
