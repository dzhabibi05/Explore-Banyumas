<x-app-layout title="Kelola Destinasi Wisata">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Kelola Destinasi Wisata') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Daftar destinasi wisata Kabupaten Banyumas</p>
            </div>
            <a href="{{ route('admin.wisata.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-5 py-2.5 rounded-full text-sm inline-flex items-center gap-2 transition duration-300 shadow-md shadow-emerald-600/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Destinasi
            </a>
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

            <!-- Search & Filters -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <form action="{{ route('admin.wisata.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ $search }}" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm placeholder:text-slate-400 text-slate-700 transition" placeholder="Cari nama wisata atau kategori...">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold px-6 py-2.5 rounded-xl text-sm transition shrink-0">
                            Cari
                        </button>
                        @if ($search)
                            <a href="{{ route('admin.wisata.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold px-4 py-2.5 rounded-xl text-sm transition shrink-0 flex items-center justify-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                <th class="py-4 px-6 w-20">Foto</th>
                                <th class="py-4 px-6">Nama Wisata</th>
                                <th class="py-4 px-6 w-36">Kategori</th>
                                <th class="py-4 px-6">Deskripsi</th>
                                <th class="py-4 px-6 w-44">Koordinat</th>
                                <th class="py-4 px-6 w-32 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                            @forelse ($wisatas as $wisata)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-4 px-6">
                                        <div class="w-12 h-12 rounded-lg overflow-hidden bg-slate-100 border border-slate-100 shadow-sm shrink-0">
                                            <img src="{{ $wisata->foto ? asset('storage/' . $wisata->foto) : 'https://images.unsplash.com/photo-1596401057633-54a8fe8ef647?q=80&w=600&auto=format&fit=crop' }}" class="w-full h-full object-cover" alt="{{ $wisata->nama_wisata }}">
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 font-bold text-slate-800">
                                        {{ $wisata->nama_wisata }}
                                    </td>
                                    <td class="py-4 px-6">
                                        @if ($wisata->kategori === 'Alam')
                                            <span class="bg-emerald-50 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                                Alam
                                            </span>
                                        @elseif ($wisata->kategori === 'Buatan')
                                            <span class="bg-sky-50 text-sky-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                                Buatan
                                            </span>
                                        @else
                                            <span class="bg-amber-50 text-amber-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                                Budaya
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 max-w-xs truncate">
                                        {{ $wisata->deskripsi }}
                                    </td>
                                    <td class="py-4 px-6 font-mono text-xs text-slate-500">
                                        {{ $wisata->latitude }},<br>{{ $wisata->longitude }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.wisata.edit', $wisata) }}" class="text-sky-600 hover:text-sky-700 hover:bg-sky-50 p-2 rounded-lg transition" title="Edit">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.wisata.destroy', $wisata) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus destinasi ini? Semua data penilaian yang terkait akan dihapus secara otomatis.');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 hover:text-rose-700 hover:bg-rose-50 p-2 rounded-lg transition" title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-10 px-6 text-center text-slate-400">
                                        Data destinasi wisata tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($wisatas->hasPages())
                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-100">
                        {{ $wisatas->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
