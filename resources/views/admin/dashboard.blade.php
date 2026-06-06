<x-app-layout title="Admin Control Panel">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Admin Control Panel') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Mengelola seluruh data master dan parameter SPK</p>
            </div>
            <span class="bg-emerald-50 text-[#457C1A] text-xs font-extrabold px-3 .py-1.5 rounded-full uppercase tracking-wider">
                Administrator
            </span>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Header Card -->
            <div class="bg-gradient-to-r from-slate-900 to-[#457C1A] rounded-[2rem] shadow-xl p-8 text-white relative overflow-hidden">
                <div class="absolute inset-0 z-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                <div class="relative z-10">
                    <span class="bg-white/20 text-white text-[10px] font-extrabold px-3 py-1 rounded-md uppercase tracking-wider">
                        Dashboard Utama
                    </span>
                    <h3 class="text-3xl font-black mt-3 mb-2">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="text-white/80 max-w-2xl text-sm leading-relaxed">
                        Di panel kontrol ini, Anda memiliki akses penuh untuk memantau data master pariwisata Banyumas, menyesuaikan bobot kriteria pengambilan keputusan, dan mengedit nilai matriks evaluasi TOPSIS secara dinamis.
                    </p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1: Wisata -->
                <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-5 hover:shadow-md transition duration-300">
                    <div class="w-14 h-14 bg-[#457C1A]/10 rounded-xl flex items-center justify-center text-[#457C1A] shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Wisata</span>
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
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Kriteria</span>
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
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Matriks Nilai</span>
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
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Pengguna</span>
                        <span class="text-3xl font-black text-slate-800">{{ $stats['total_users'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Management Section -->
            <div class="space-y-6">
                <div class="border-b border-slate-200 pb-3 flex items-center gap-3">
                    <span class="text-[#457C1A] text-xl">🌿</span>
                    <h4 class="text-lg font-black text-slate-800">Manajemen Parameter SPK TOPSIS</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Action 1: Wisata -->
                    <div class="bg-white rounded-tr-[4rem] rounded-bl-[4rem] rounded-tl-[1.5rem] rounded-br-[1.5rem] border border-slate-100 shadow-[0_15px_35px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col hover:-translate-y-1 hover:shadow-xl transition duration-300">
                        <div class="p-6 sm:p-7 flex-1">
                            <span class="text-xs font-bold text-[#457C1A] uppercase tracking-widest">Alternatif</span>
                            <h5 class="font-extrabold text-xl text-slate-800 mt-2 mb-3">Destinasi Wisata</h5>
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Kelola tempat pariwisata di Kabupaten Banyumas, termasuk menentukan kategori, mengunggah foto, serta melacak titik koordinat lokasi di peta.
                            </p>
                        </div>
                        <div class="bg-slate-50/50 px-6 py-4 border-t border-slate-100">
                            <a href="{{ route('admin.wisata.index') }}" class="text-[#457C1A] hover:text-[#2d5211] font-bold text-sm inline-flex items-center gap-1.5 transition">
                                Kelola Wisata 
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Action 2: Kriteria -->
                    <div class="bg-white rounded-tr-[4rem] rounded-bl-[4rem] rounded-tl-[1.5rem] rounded-br-[1.5rem] border border-slate-100 shadow-[0_15px_35px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col hover:-translate-y-1 hover:shadow-xl transition duration-300">
                        <div class="p-6 sm:p-7 flex-1">
                            <span class="text-xs font-bold text-[#457C1A] uppercase tracking-widest">Bobot Kepentingan</span>
                            <h5 class="font-extrabold text-xl text-slate-800 mt-2 mb-3">Kriteria & Parameter</h5>
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Atur dan sesuaikan bobot nilai kepentingan kriteria (C1 hingga C4) serta ubah tipe kriteria apakah bernilai Cost atau Benefit.
                            </p>
                        </div>
                        <div class="bg-slate-50/50 px-6 py-4 border-t border-slate-100">
                            <a href="{{ route('admin.kriteria.index') }}" class="text-[#457C1A] hover:text-[#2d5211] font-bold text-sm inline-flex items-center gap-1.5 transition">
                                Kelola Kriteria
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Action 3: Penilaian Matrix -->
                    <div class="bg-white rounded-tr-[4rem] rounded-bl-[4rem] rounded-tl-[1.5rem] rounded-br-[1.5rem] border border-slate-100 shadow-[0_15px_35px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col hover:-translate-y-1 hover:shadow-xl transition duration-300">
                        <div class="p-6 sm:p-7 flex-1">
                            <span class="text-xs font-bold text-[#457C1A] uppercase tracking-widest">Matriks Keputusan</span>
                            <h5 class="font-extrabold text-xl text-slate-800 mt-2 mb-3">Matriks Penilaian</h5>
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Perbarui matriks performa nilai alternatif setiap tempat pariwisata terhadap kriteria Harga (C2), Rating (C3), dan Fasilitas (C4).
                            </p>
                        </div>
                        <div class="bg-slate-50/50 px-6 py-4 border-t border-slate-100">
                            <a href="{{ route('admin.penilaian.index') }}" class="text-[#457C1A] hover:text-[#2d5211] font-bold text-sm inline-flex items-center gap-1.5 transition">
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
