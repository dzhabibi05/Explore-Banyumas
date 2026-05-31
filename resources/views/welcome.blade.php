<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eksplore Banyumas</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Google Fonts - Happy Monkey -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Happy+Monkey&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        /* Custom scroll smooth */
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="min-h-screen bg-white font-sans text-slate-800 pb-20 relative overflow-x-hidden">

    <nav class="absolute w-full top-0 left-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center bg-white rounded-b-[2.5rem] px-6 sm:px-8 shadow-lg">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14 w-auto" />
                </div>
                
                <div class="flex items-center gap-4 sm:gap-6 text-sm sm:text-base font-bold">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="border border-green-700 text-green-700 px-3 py-1.5 sm:px-5 sm:py-2 rounded-full hover:bg-green-700 hover:text-white transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="border border-green-700 text-green-700 px-3 py-1.5 sm:px-5 sm:py-2 rounded-full hover:bg-green-700 hover:text-white transition">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="border border-green-700 text-green-700 px-3 py-1.5 sm:px-5 sm:py-2 rounded-full hover:bg-green-700 hover:text-white transition">Daftar</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative w-full h-[600px] rounded-b-[4rem] overflow-hidden shadow-2xl">
        <img src="{{ asset('images/landscape.jpeg') }}" alt="Pemandangan" class="absolute inset-0 w-full h-full object-cover object-center"/>
        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center" data-aos="fade-up" data-aos-duration="1000">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-white tracking-tight mb-2 drop-shadow-lg leading-tight uppercase">
                Jelajahi Keindahan <br /> Wisata Banyumas
            </h1>
            <p class="text-white/90 text-sm sm:text-base md:text-lg mb-6 sm:mb-8 tracking-wide font-light">TEMUKAN PESONA HIJAU DI JAWA TENGAH</p>
            <div>
                <a href="#destinasi" class="bg-green-600 text-white px-6 py-2.5 sm:px-8 sm:py-3 rounded-full font-bold hover:bg-green-700 transition shadow-lg shadow-green-900/50 text-sm sm:text-base">
                    Mulai Jelajah!
                </a>
            </div>
        </div>
    </div>

    <div id="destinasi" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative">
        
        <div class="text-center mb-10" data-aos="fade-up">
            <div class="inline-block border border-green-200 rounded-full px-6 py-2 mb-6">
                <h2 class="text-xl font-bold text-green-800">Jelajahi Banyumas</h2>
                <p class="text-xs text-green-600">Eksplorasi manual destinasi pilihan yang tersedia di sistem kami.</p>
            </div>

            <div class="flex flex-wrap justify-center gap-2 sm:gap-3" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ url('/#destinasi') }}" class="px-3 py-1.5 sm:px-5 sm:py-2 rounded-full text-xs sm:text-sm font-bold transition border {{ !request('kategori') ? 'bg-green-700 border-green-700 text-white shadow-md' : 'bg-white border-green-700 text-green-700 hover:bg-green-50' }}">
                    Semua Wisata
                </a>
                <a href="{{ url('/?kategori=Alam#destinasi') }}" class="px-3 py-1.5 sm:px-5 sm:py-2 rounded-full text-xs sm:text-sm font-bold transition border {{ request('kategori') === 'Alam' ? 'bg-green-700 border-green-700 text-white shadow-md' : 'bg-white border-green-700 text-green-700 hover:bg-green-50' }}">
                    Wisata Alam
                </a>
                <a href="{{ url('/?kategori=Buatan#destinasi') }}" class="px-3 py-1.5 sm:px-5 sm:py-2 rounded-full text-xs sm:text-sm font-bold transition border {{ request('kategori') === 'Buatan' ? 'bg-green-700 border-green-700 text-white shadow-md' : 'bg-white border-green-700 text-green-700 hover:bg-green-50' }}">
                    Wisata Buatan
                </a>
                <a href="{{ url('/?kategori=Budaya#destinasi') }}" class="px-3 py-1.5 sm:px-5 sm:py-2 rounded-full text-xs sm:text-sm font-bold transition border {{ request('kategori') === 'Budaya' ? 'bg-green-700 border-green-700 text-white shadow-md' : 'bg-white border-green-700 text-green-700 hover:bg-green-50' }}">
                    Wisata Budaya & Sejarah
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-x-8 gap-y-12 px-4 md:px-10">
            @if(isset($destinasi) && $destinasi->count() > 0)
                @foreach($destinasi as $item)
                    <div class="bg-white rounded-tr-[5.5rem] rounded-bl-[5.5rem] rounded-tl-[1rem] rounded-br-[1rem] shadow-[0_15px_35px_rgba(0,0,0,0.08)] border border-slate-100 flex flex-col items-center p-4 h-full transition duration-300 hover:-translate-y-2 hover:shadow-2xl cursor-pointer" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        
                        <div class="w-full h-48 overflow-hidden rounded-tr-[4.5rem] rounded-bl-[4.5rem] rounded-tl-[0.5rem] rounded-br-[0.5rem] relative group shadow-inner">
                            <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://images.unsplash.com/photo-1596401057633-54a8fe8ef647?q=80&w=600&auto=format&fit=crop' }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="{{ $item->nama_wisata }}" />
                        </div>
 
                        <div class="bg-[#457C1A] text-white font-bold text-sm sm:text-base px-6 py-2 rounded-tr-[1.2rem] rounded-bl-[1.2rem] rounded-tl-[0.3rem] rounded-br-[0.3rem] shadow-md text-center mt-4 mb-3 max-w-[90%] truncate overflow-hidden">
                            {{ \Illuminate\Support\Str::words($item->nama_wisata, 3, '...') }}
                        </div>
 
                        <div class="px-2 pb-2 text-center flex-1 flex flex-col justify-center">
                            <p class="text-xs sm:text-sm text-[#008404] font-bold leading-relaxed" style="font-family: 'Happy Monkey', system-ui; font-weight: bold;">
                                {{ $item->deskripsi }}
                            </p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-span-full text-center text-slate-500 py-10">Belum ada data wisata.</div>
            @endif
        </div>

        <div class="mt-12 flex justify-center">
            {{ $destinasi->fragment('destinasi')->links() }}
        </div>
    </div>

    <div class="my-10 w-full overflow-hidden flex justify-center" data-aos="fade-up">
        <img src="{{ asset('images/bambu.png') }}" alt="Ornamen Bambu" class="w-full h-auto object-cover opacity-90" />
    </div>

    <div class="py-16 relative overflow-hidden">
        
        <!-- Ornamen Daun di Sudut-Sudut -->
        <img src="{{ asset('images/daun-kiri-bawah.png') }}" alt="Ornamen Daun Kiri Bawah" class="absolute bottom-0 left-0 w-32 md:w-48 h-auto pointer-events-none z-0" />
        <img src="{{ asset('images/daun-kanan-bawah.png') }}" alt="Ornamen Daun Kanan Bawah" class="absolute bottom-0 right-0 w-32 md:w-48 h-auto pointer-events-none z-0" />

        <div class="text-center mb-8 relative z-10" data-aos="fade-up">
            <h2 class="text-2xl font-black text-green-700">Mulai Pencarian Wisata</h2>
        </div>

        <div class="max-w-4xl mx-auto px-4 relative z-10" data-aos="zoom-in" data-aos-duration="1000">
            @auth
                <div class="bg-white rounded-[2.5rem] shadow-2xl p-8 md:p-12 border border-slate-100">
                    <form action="{{ route('rekomendasi.proses') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="col-span-2">
                                <label class="block text-sm font-bold text-slate-700 mb-1">Nama Lengkap</label>
                                <input type="text" name="nama" class="w-full rounded-xl border-slate-300 bg-slate-50 focus:ring-green-600 focus:border-green-600" placeholder="Masukkan nama..." required>
                            </div>
                            
                            <div class="col-span-2 bg-green-50/50 p-5 rounded-2xl border border-green-100">
                                <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-2 mb-4">
                                    <label class="block text-sm font-bold text-green-800">Deteksi Titik Koordinat</label>
                                    <button type="button" id="btn-lokasi" onclick="lacakLokasi()" class="bg-green-700 hover:bg-green-800 text-white text-xs px-4 py-2 rounded-full font-bold transition shadow-md w-full sm:w-auto text-center">
                                        📍 Lacak Lokasi
                                    </button>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-xs font-bold text-green-700/70">Latitude</span>
                                        <input type="text" id="lat" name="latitude" readonly class="w-full rounded-xl border-green-200 bg-white text-slate-600 font-mono text-sm shadow-sm" required>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-green-700/70">Longitude</span>
                                        <input type="text" id="lng" name="longitude" readonly class="w-full rounded-xl border-green-200 bg-white text-slate-600 font-mono text-sm shadow-sm" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-2 mt-2">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Kategori Minat</label>
                                <select name="kategori" class="w-full rounded-xl border-slate-300 bg-slate-50 focus:ring-green-600 focus:border-green-600" required>
                                    <option value="Alam">Wisata Alam</option>
                                    <option value="Buatan">Wisata Buatan</option>
                                    <option value="Budaya">Wisata Budaya</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-8 text-center">
                            <button type="submit" class="bg-green-600 text-white px-10 py-3 rounded-full font-black text-lg hover:bg-green-700 transition shadow-lg shadow-green-200">
                                Proses Rekomendasi
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="bg-[#427A21] rounded-[3rem] shadow-[0_20px_50px_rgb(66,122,33,0.3)] p-6 sm:p-10 md:p-16 text-center text-white relative overflow-hidden">
                    <div class="mx-auto w-14 h-14 bg-green-900/30 rounded-full flex items-center justify-center mb-6 border border-green-400/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    
                    <h3 class="font-bold text-xl md:text-2xl mb-4">Mulai Pencarian Wisata</h3>
                    <p class="text-green-100 text-sm md:text-base max-w-lg mx-auto mb-6 sm:mb-10 leading-relaxed font-light">
                        Silahkan masuk ke akun dahulu agar sistem dapat mendeteksi koordinat lokasi anda secara presisi dan memproses kalkulasi TOPSIS rute jalan berkendara riil.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="{{ route('login') }}" class="border border-[#5DB02F] text-white hover:bg-[#5DB02F] px-6 py-2.5 sm:px-10 sm:py-3 rounded-full font-bold transition hover:shadow-lg hover:shadow-green-900/50 w-full sm:w-auto text-center">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="border border-[#5DB02F] text-white hover:bg-[#5DB02F] px-6 py-2.5 sm:px-10 sm:py-3 rounded-full font-bold transition hover:shadow-lg hover:shadow-green-900/50 w-full sm:w-auto text-center">
                                Daftar Akun
                            </a>
                        @endif
                    </div>
                </div>
            @endauth
        </div>
    </div>

    <script>
        function lacakLokasi() {
            const btn = document.getElementById('btn-lokasi');
            const latInput = document.getElementById('lat');
            const lngInput = document.getElementById('lng');

            btn.innerText = 'Mendeteksi...';
            btn.disabled = true;

            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        latInput.value = position.coords.latitude.toFixed(6);
                        lngInput.value = position.coords.longitude.toFixed(6);
                        btn.innerText = '📍 Lacak Selesai';
                        btn.classList.replace('bg-green-700', 'bg-slate-800');
                    },
                    function(error) {
                        alert("Gagal mendapatkan lokasi. Pastikan izin lokasi browser diaktifkan.");
                        btn.innerText = '📍 Lacak Lokasi';
                        btn.disabled = false;
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            } else {
                alert("Browser Anda tidak mendukung Geolocation.");
            }
        }
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
        });
    </script>
</body>
</html>