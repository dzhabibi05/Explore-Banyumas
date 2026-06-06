<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Explore Banyumas</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
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

    <div class="relative w-full h-[450px] md:h-[550px] rounded-b-[3rem] md:rounded-b-[5rem] overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.15)] z-20">
        <img src="{{ asset('images/landscape.jpeg') }}" alt="Pemandangan" class="absolute inset-0 w-full h-full object-cover object-center"/>
        
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center pt-10" data-aos="fade-right" data-aos-duration="1000">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-white tracking-tight mb-2 drop-shadow-lg leading-tight uppercase">
                Jelajahi Keindahan <br /> Alam Banyumas
            </h1>
            <p class="text-white/80 text-xs md:text-sm lg:text-base mb-8 tracking-widest font-light uppercase">
                Temukan Pesona Hijau di Jawa Tengah
            </p>
            <div>
                <a href="#destinasi" class="bg-[#15803d] text-white px-8 py-3 rounded-full font-bold hover:bg-[#166534] transition shadow-lg text-sm uppercase tracking-wider inline-block">
                    Mulai Jelajah!
                </a>
            </div>
        </div>
    </div>

    <div class="w-full relative h-0 z-30 pointer-events-none max-w-7xl mx-auto">
        <img src="{{ asset('images/daun-kiri-atas.png') }}" alt="Ornamen Daun Kiri" class="absolute -top-12 left-0 w-32 md:w-48 lg:w-56 transform -translate-x-4 object-contain drop-shadow-xl" data-aos="fade-right" data-aos-delay="200" />
        
        <img src="{{ asset('images/daun-kanan-atas.png') }}" alt="Ornamen Daun Kanan" class="absolute -top-24 right-0 w-24 md:w-36 lg:w-48 transform translate-x-2 object-contain drop-shadow-xl" data-aos="fade-left" data-aos-delay="400" />
    </div>

    <div id="destinasi" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-20 relative z-10">
        
        <div class="text-center mb-10" data-aos="fade-up">
            <div class="inline-block border border-green-200 rounded-full px-8 py-2 mb-6 shadow-sm bg-white">
                <h2 class="text-xl md:text-2xl font-bold text-green-800">Jelajahi Banyumas</h2>
                <p class="text-[10px] md:text-xs text-green-600 tracking-wider">Eksplorasi manual destinasi pilihan yang tersedia di sistem kami</p>
            </div>

            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ url('/#destinasi') }}" class="px-5 py-2 rounded-full text-xs md:text-sm font-bold transition border {{ !request('kategori') ? 'bg-green-700 border-green-700 text-white shadow-md' : 'bg-white border-green-700 text-green-700 hover:bg-green-50' }}">
                    Semua Wisata
                </a>
                <a href="{{ url('/?kategori=Alam#destinasi') }}" class="px-5 py-2 rounded-full text-xs md:text-sm font-bold transition border {{ request('kategori') === 'Alam' ? 'bg-green-700 border-green-700 text-white shadow-md' : 'bg-white border-green-700 text-green-700 hover:bg-green-50' }}">
                    Wisata Alam
                </a>
                <a href="{{ url('/?kategori=Buatan#destinasi') }}" class="px-5 py-2 rounded-full text-xs md:text-sm font-bold transition border {{ request('kategori') === 'Buatan' ? 'bg-green-700 border-green-700 text-white shadow-md' : 'bg-white border-green-700 text-green-700 hover:bg-green-50' }}">
                    Wisata Buatan
                </a>
                <a href="{{ url('/?kategori=Budaya#destinasi') }}" class="px-5 py-2 rounded-full text-xs md:text-sm font-bold transition border {{ request('kategori') === 'Budaya' ? 'bg-green-700 border-green-700 text-white shadow-md' : 'bg-white border-green-700 text-green-700 hover:bg-green-50' }}">
                    Wisata Budaya & Sejarah
                </a>
            </div>
        </div>

        <div class="relative max-w-5xl mx-auto mt-12">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-x-8 gap-y-12 px-4 md:px-8 relative z-40">
                @if(isset($destinasi) && $destinasi->count() > 0)
                    @foreach($destinasi as $item)
                        <div class="bg-white rounded-tr-[5rem] rounded-bl-[5rem] rounded-tl-[1.5rem] rounded-br-[1.5rem] shadow-[0_15px_35px_rgba(0,0,0,0.06)] border border-slate-100 flex flex-col items-center p-3 h-full transition duration-300 hover:-translate-y-2 hover:shadow-2xl cursor-pointer" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                            
                            <div class="w-full h-44 overflow-hidden rounded-tr-[4.5rem] rounded-bl-[4.5rem] rounded-tl-[1rem] rounded-br-[1rem] relative group shadow-sm bg-slate-100">
                                <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://images.unsplash.com/photo-1596401057633-54a8fe8ef647?q=80&w=600&auto=format&fit=crop' }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="{{ $item->nama_wisata }}" />
                            </div>

                            <div class="bg-[#2a6813] text-white font-extrabold text-sm px-6 py-1.5 rounded-tr-[1rem] rounded-bl-[1rem] rounded-tl-[0.25rem] rounded-br-[0.25rem] shadow-md text-center -mt-4 mb-3 max-w-[85%] relative z-10 uppercase tracking-wide">
                                {{ \Illuminate\Support\Str::words($item->nama_wisata, 4, '...') }}
                            </div>

                            <div class="px-4 pb-4 text-center flex-1 flex flex-col justify-start w-full">
                                <p class="text-[11px] md:text-xs text-[#2a6813] font-normal leading-relaxed text-center" style="font-family: 'Happy Monkey', cursive;">
                                    {{ $item->deskripsi }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full text-center text-slate-500 py-10">Belum ada data wisata.</div>
                @endif
            </div>

            <div class="mt-12 flex justify-center relative z-50 px-4">
                {{ $destinasi->fragment('destinasi')->links() }}
            </div>

        </div>
    
    </div>

    <div class="my-10 w-full overflow-hidden flex justify-center" data-aos="fade-up">
        <img src="{{ asset('images/bambu.png') }}" alt="Ornamen Bambu" class="w-full h-auto object-cover opacity-90" />
    </div>

    <div class="py-16 relative overflow-hidden">
        
        <img src="{{ asset('images/daun-kiri-bawah.png') }}" alt="Ornamen Daun Kiri Bawah" class="absolute bottom-0 left-0 w-32 md:w-48 h-auto pointer-events-none z-0" />
        <img src="{{ asset('images/daun-kanan-bawah.png') }}" alt="Ornamen Daun Kanan Bawah" class="absolute bottom-0 right-0 w-32 md:w-48 h-auto pointer-events-none z-0" />

        <div class="text-center mb-8 relative z-10" data-aos="fade-up">
            <h2 class="text-2xl font-black text-green-700">Mulai Pencarian Wisata</h2>
        </div>

        <div class="max-w-4xl mx-auto px-4 relative z-10" data-aos="zoom-in" data-aos-duration="1000">
            @auth
                <div class="bg-[#4A7D29] rounded-[2rem] shadow-2xl p-8 md:p-12 border border-green-800/20 mx-auto max-w-4xl relative overflow-hidden">
                    <form action="{{ route('rekomendasi.proses') }}" method="POST">
                        @csrf
                        <div class="flex flex-col gap-6">
                            
                            <div>
                                <label class="block text-sm font-bold text-white mb-2 ml-2 tracking-wide">Nama Lengkap</label>
                                <input type="text" name="nama" 
                                    value="{{ Auth::user()->name }}" 
                                    class="w-full rounded-full border-none py-3 px-5 text-sm text-slate-700 shadow-inner focus:ring-4 focus:ring-green-400 focus:outline-none" 
                                    placeholder="Masukkan nama Anda..." 
                                    required>
                            </div>
                            
                            <div class="bg-[#6B9E40]/90 rounded-3xl p-6 md:p-8 shadow-inner border border-[#85B85A]">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-5">
                                    <label class="block text-sm font-bold text-white ml-2 tracking-wide">Deteksi Titik Koordinat</label>
                                    <button type="button" id="btn-lokasi" onclick="lacakLokasi()" class="bg-[#2DCC2D] hover:bg-green-500 text-white text-xs px-6 py-2.5 rounded-md font-extrabold transition shadow-[0_4px_14px_0_rgba(45,204,45,0.39)] uppercase tracking-wider">
                                        Lacak Lokasi Saya
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div>
                                        <input type="text" id="lat" name="latitude" readonly class="w-full rounded-full border-none py-3 px-5 text-sm font-bold text-slate-400 bg-white/95 shadow-inner placeholder:font-normal placeholder:text-slate-300 focus:ring-0" placeholder="Deteksi Titik Koordinat" required>
                                    </div>
                                    <div>
                                        <input type="text" id="lng" name="longitude" readonly class="w-full rounded-full border-none py-3 px-5 text-sm font-bold text-slate-400 bg-white/95 shadow-inner placeholder:font-normal placeholder:text-slate-300 focus:ring-0" placeholder="Deteksi Titik Koordinat" required>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-white mb-2 ml-2 tracking-wide">Pilih Kategori Minat</label>
                                <div class="relative">
                                    <select name="kategori" class="w-full rounded-full border-none py-3 px-5 text-sm text-slate-400 bg-white shadow-inner focus:ring-4 focus:ring-green-400 focus:outline-none appearance-none cursor-pointer font-medium" required>
                                        <option value="" disabled selected hidden>Pilih Kategori (Alam, Buatan, Budaya)...</option>
                                        <option value="Alam" class="text-slate-700">Wisata Alam</option>
                                        <option value="Buatan" class="text-slate-700">Wisata Buatan</option>
                                        <option value="Budaya" class="text-slate-700">Wisata Budaya & Sejarah</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-slate-400">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex justify-center">
                                <button type="submit" class="bg-[#F59E0B] text-white px-12 py-3.5 rounded-full font-black text-sm uppercase tracking-wider hover:bg-[#D97706] transition shadow-[0_4px_14px_0_rgba(245,158,11,0.39)]">
                                    Proses Rekomendasi
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            @else
                <div class="bg-[#4A7D29] rounded-[2rem] shadow-2xl p-6 sm:p-10 md:p-16 text-center text-white relative overflow-hidden mx-auto max-w-4xl">
                    <div class="mx-auto w-16 h-16 bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center mb-6 border border-white/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    
                    <h3 class="font-bold text-2xl md:text-3xl mb-4">Akses Terbatas</h3>
                    <p class="text-green-100 text-sm md:text-base max-w-lg mx-auto mb-8 sm:mb-10 leading-relaxed font-light">
                        Silahkan masuk ke akun dahulu agar sistem dapat mendeteksi koordinat lokasi anda secara presisi dan memproses kalkulasi TOPSIS rute jalan berkendara riil.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="{{ route('login') }}" class="border-2 border-white/50 text-white hover:bg-[#D97706] px-10 py-3 rounded-full font-bold transition shadow-lg w-full sm:w-auto text-center uppercase text-sm tracking-wider">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="border-2 border-white/50 text-white hover:bg-[#D97706] px-10 py-2.5 rounded-full font-bold transition w-full sm:w-auto text-center uppercase text-sm tracking-wider">
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
            disable: function() {
                return window.innerWidth < 768;
            }
        });
    </script>
</body>
</html>