<x-app-layout title="Admin Control Panel">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Admin Control Panel') }}
            </h2>
            <span class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">
                Role: Administrator
            </span>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Header -->
            <div class="bg-gradient-to-r from-slate-900 to-emerald-900 rounded-3xl shadow-xl p-8 text-white relative overflow-hidden">
                <div class="absolute inset-0 z-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                <div class="relative z-10">
                    <h3 class="text-3xl font-extrabold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="text-emerald-100 max-w-2xl text-sm leading-relaxed">
                        Di panel kontrol ini, Anda memiliki akses penuh untuk memantau data master pariwisata, menyesuaikan bobot kriteria pengambilan keputusan, dan mengelola penilaian matriks TOPSIS.
                    </p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1: Wisata -->
                <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-5 hover:shadow-md transition duration-300">
                    <div class="w-14 h-14 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Wisata</span>
                        <span class="text-3xl font-black text-slate-800">{{ $stats['total_wisata'] }}</span>
                    </div>
                </div>

                <!-- Card 2: Kriteria -->
                <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-5 hover:shadow-md transition duration-300">
                    <div class="w-14 h-14 bg-sky-50 rounded-xl flex items-center justify-center text-sky-600 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Kriteria</span>
                        <span class="text-3xl font-black text-slate-800">{{ $stats['total_kriteria'] }}</span>
                    </div>
                </div>

                <!-- Card 3: Penilaian Matrix -->
                <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-5 hover:shadow-md transition duration-300">
                    <div class="w-14 h-14 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Matriks Nilai</span>
                        <span class="text-3xl font-black text-slate-800">{{ $stats['total_penilaian'] }}</span>
                    </div>
                </div>

                <!-- Card 4: Pengguna -->
                <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-5 hover:shadow-md transition duration-300">
                    <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pengguna</span>
                        <span class="text-3xl font-black text-slate-800">{{ $stats['total_users'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Management Section -->
            <div class="space-y-4">
                <h4 class="text-lg font-bold text-slate-800">Manajemen Parameter SPK TOPSIS</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Action 1: Wisata -->
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition duration-300">
                        <div class="p-6 flex-1">
                            <h5 class="font-bold text-lg text-slate-800 mb-2">Data Destinasi Wisata</h5>
                            <p class="text-slate-500 text-sm leading-relaxed mb-4">
                                Kelola tempat wisata di Kabupaten Banyumas, termasuk menambah koordinat peta, kategori, foto, dan deskripsi wisata.
                            </p>
                        </div>
                        <div class="bg-slate-50 px-6 py-4 border-t border-slate-100">
                            <a href="#" class="text-emerald-600 hover:text-emerald-700 font-semibold text-sm inline-flex items-center gap-1.5 transition">
                                Kelola Wisata 
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Action 2: Kriteria -->
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition duration-300">
                        <div class="p-6 flex-1">
                            <h5 class="font-bold text-lg text-slate-800 mb-2">Kriteria & Bobot</h5>
                            <p class="text-slate-500 text-sm leading-relaxed mb-4">
                                Sesuaikan bobot kepentingan dan tipe kriteria (Cost vs Benefit) untuk C1 (Jarak) hingga C4 (Fasilitas).
                            </p>
                        </div>
                        <div class="bg-slate-50 px-6 py-4 border-t border-slate-100">
                            <a href="#" class="text-emerald-600 hover:text-emerald-700 font-semibold text-sm inline-flex items-center gap-1.5 transition">
                                Kelola Kriteria
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Action 3: Penilaian Matrix -->
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition duration-300">
                        <div class="p-6 flex-1">
                            <h5 class="font-bold text-lg text-slate-800 mb-2">Matriks Penilaian</h5>
                            <p class="text-slate-500 text-sm leading-relaxed mb-4">
                                Isi nilai performa setiap alternatif wisata terhadap kriteria Harga Tiket (C2), Rating (C3), dan Fasilitas (C4).
                            </p>
                        </div>
                        <div class="bg-slate-50 px-6 py-4 border-t border-slate-100">
                            <a href="#" class="text-emerald-600 hover:text-emerald-700 font-semibold text-sm inline-flex items-center gap-1.5 transition">
                                Kelola Matriks
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
