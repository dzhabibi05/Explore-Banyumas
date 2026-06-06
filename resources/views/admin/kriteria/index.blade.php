<x-app-layout title="Kelola Kriteria & Bobot SPK">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Kelola Kriteria & Bobot SPK') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Atur bobot kepentingan dan tipe kriteria TOPSIS</p>
            </div>
            <span class="bg-indigo-50 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">
                Model: TOPSIS
            </span>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

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
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex gap-4 items-start">
                <div class="p-3 bg-amber-50 rounded-xl text-amber-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-sm">Penjelasan Tipe Kriteria</h3>
                    <p class="text-slate-500 text-xs mt-1.5 leading-relaxed">
                        <strong>Cost (Biaya):</strong> Semakin kecil nilai alternatif, semakin baik. Contoh: Jarak (C1) dan Harga Tiket (C2).<br>
                        <strong>Benefit (Manfaat):</strong> Semakin besar nilai alternatif, semakin baik. Contoh: Rating (C3) dan Fasilitas (C4).<br>
                        <span class="text-slate-400 mt-1 block">Catatan: Perubahan bobot atau tipe akan langsung memengaruhi pemeringkatan rekomendasi TOPSIS secara dinamis.</span>
                    </p>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <form action="{{ route('admin.kriteria.update') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                    @csrf
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100 text-xs font-bold text-slate-400 uppercase tracking-wider pb-4">
                                    <th class="pb-3 px-4 w-24">Kode</th>
                                    <th class="pb-3 px-4">Nama Kriteria</th>
                                    <th class="pb-3 px-4 w-44">Tipe Kriteria</th>
                                    <th class="pb-3 px-4 w-48">Bobot Kepentingan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                                @foreach ($kriterias as $kriteria)
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <!-- Code -->
                                        <td class="py-4 px-4 font-bold text-slate-800">
                                            <span class="bg-slate-100 text-slate-800 text-xs font-bold px-2.5 py-1 rounded-lg">
                                                {{ $kriteria->kode }}
                                            </span>
                                        </td>
                                        <!-- Name -->
                                        <td class="py-4 px-4 font-semibold text-slate-700">
                                            {{ $kriteria->nama_kriteria }}
                                        </td>
                                        <!-- Type -->
                                        <td class="py-4 px-4">
                                            <select name="kriteria[{{ $kriteria->id }}][tipe]" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-xs text-slate-700 bg-white transition" required>
                                                <option value="cost" {{ $kriteria->tipe === 'cost' ? 'selected' : '' }}>Cost (Biaya)</option>
                                                <option value="benefit" {{ $kriteria->tipe === 'benefit' ? 'selected' : '' }}>Benefit (Manfaat)</option>
                                            </select>
                                        </td>
                                        <!-- Weight -->
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-2">
                                                <input type="number" step="0.1" min="0" name="kriteria[{{ $kriteria->id }}][bobot]" value="{{ $kriteria->bobot }}" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-xs font-mono text-slate-700 transition" placeholder="Contoh: 3.0" required>
                                                <span class="text-xs text-slate-400 font-semibold">Poin</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="border-t border-slate-100 pt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.dashboard') }}" class="px-6 py-2.5 rounded-full border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-sm transition">
                            Kembali
                        </a>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-2.5 rounded-full text-sm transition duration-300 shadow-md shadow-emerald-600/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
