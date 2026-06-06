<x-app-layout title="Tambah Destinasi Wisata">
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.wisata.index') }}" class="text-slate-500 hover:text-slate-800 transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Tambah Destinasi Wisata') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Buat data wisata baru dengan koordinat lokasi peta</p>
            </div>
        </div>
    </x-slot>

    <!-- Leaflet.js CSS and JS CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8">
                <form action="{{ route('admin.wisata.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- Main fields grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <!-- Left: Text fields & Photo -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-3">Informasi Umum</h3>
                            
                            <!-- Nama Wisata -->
                            <div>
                                <label for="nama_wisata" class="block text-sm font-semibold text-slate-700 mb-2">Nama Wisata</label>
                                <input type="text" name="nama_wisata" id="nama_wisata" value="{{ old('nama_wisata') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('nama_wisata') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror" placeholder="Contoh: Curug Telu Baturraden" required>
                                @error('nama_wisata')
                                    <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label for="kategori" class="block text-sm font-semibold text-slate-700 mb-2">Kategori Wisata</label>
                                <select name="kategori" id="kategori" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('kategori') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    <option value="Alam" {{ old('kategori') === 'Alam' ? 'selected' : '' }}>Wisata Alam</option>
                                    <option value="Buatan" {{ old('kategori') === 'Buatan' ? 'selected' : '' }}>Wisata Buatan</option>
                                    <option value="Budaya" {{ old('kategori') === 'Budaya' ? 'selected' : '' }}>Wisata Budaya & Sejarah</option>
                                </select>
                                @error('kategori')
                                    <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Lengkap</label>
                                <textarea name="deskripsi" id="deskripsi" rows="5" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('deskripsi') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror" placeholder="Tuliskan ulasan singkat mengenai pesona, lokasi, jam buka, atau keunikan wisata ini..." required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Foto -->
                            <div>
                                <label for="foto" class="block text-sm font-semibold text-slate-700 mb-2">Foto Destinasi Wisata</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-emerald-500 transition duration-300">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-slate-600">
                                            <label for="foto" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                                                <span>Unggah file foto</span>
                                                <input id="foto" name="foto" type="file" accept="image/*" class="sr-only">
                                            </label>
                                            <p class="pl-1">atau seret dan taruh</p>
                                        </div>
                                        <p class="text-xs text-slate-400">PNG, JPG, JPEG, WEBP hingga 2MB</p>
                                    </div>
                                </div>
                                @error('foto')
                                    <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                                <!-- Image Preview Container -->
                                <div id="preview-container" class="hidden mt-4">
                                    <p class="text-xs font-semibold text-slate-500 mb-2">Pratinjau Foto:</p>
                                    <img id="image-preview" src="#" class="max-h-48 rounded-xl object-cover border border-slate-100 shadow-sm" alt="Preview">
                                </div>
                            </div>
                        </div>

                        <!-- Right: Interactive Map Picker -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-3">Titik Geografis (Peta)</h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Latitude -->
                                <div>
                                    <label for="latitude" class="block text-sm font-semibold text-slate-700 mb-2">Latitude</label>
                                    <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-mono @error('latitude') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror" placeholder="-7.31381" required>
                                    @error('latitude')
                                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Longitude -->
                                <div>
                                    <label for="longitude" class="block text-sm font-semibold text-slate-700 mb-2">Longitude</label>
                                    <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-mono @error('longitude') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror" placeholder="109.22981" required>
                                    @error('longitude')
                                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Map Container -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-slate-700">Tentukan Lokasi dengan Klik Peta</label>
                                <div id="map" class="w-full h-80 rounded-2xl border border-slate-200 shadow-sm z-10"></div>
                                <span class="text-xs text-slate-400 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Geser peta dan klik untuk meletakkan pin koordinat. Pin dapat digeser secara bebas.
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="border-t border-slate-100 pt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.wisata.index') }}" class="px-6 py-2.5 rounded-full border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-sm transition">
                            Batal
                        </a>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-2.5 rounded-full text-sm transition duration-300 shadow-md shadow-emerald-600/20">
                            Simpan Destinasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript to Handle Map Logic & File Preview -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Photo Preview Handler
            const fotoInput = document.getElementById('foto');
            const previewContainer = document.getElementById('preview-container');
            const imagePreview = document.getElementById('image-preview');

            fotoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.classList.add('hidden');
                }
            });

            // Map Initialization (Default center: Banyumas/Purwokerto)
            const defaultLat = -7.4244;
            const defaultLng = 109.2300;
            
            // Set initial map coordinates
            const initLat = parseFloat(document.getElementById('latitude').value) || defaultLat;
            const initLng = parseFloat(document.getElementById('longitude').value) || defaultLng;

            const map = L.map('map').setView([initLat, initLng], 12);

            // Add standard OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Create marker
            let marker;
            
            if (document.getElementById('latitude').value && document.getElementById('longitude').value) {
                marker = L.marker([initLat, initLng], { draggable: true }).addTo(map);
            }

            // Sync inputs with marker
            function updateLatLng(lat, lng) {
                document.getElementById('latitude').value = parseFloat(lat).toFixed(6);
                document.getElementById('longitude').value = parseFloat(lng).toFixed(6);
            }

            // Map click listener
            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng, { draggable: true }).addTo(map);
                    
                    // Trigger input sync when dragged
                    marker.on('dragend', function(event) {
                        const position = marker.getLatLng();
                        updateLatLng(position.lat, position.lng);
                    });
                }
                updateLatLng(lat, lng);
            });

            // If marker exists, bind drag events
            if (marker) {
                marker.on('dragend', function(event) {
                    const position = marker.getLatLng();
                    updateLatLng(position.lat, position.lng);
                });
            }

            // Listen to coordinate manual input changes
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');

            function syncMapFromInputs() {
                const latVal = parseFloat(latInput.value);
                const lngVal = parseFloat(lngInput.value);

                if (!isNaN(latVal) && !isNaN(lngVal) && latVal >= -90 && latVal <= 90 && lngVal >= -180 && lngVal <= 180) {
                    const latlng = [latVal, lngVal];
                    if (marker) {
                        marker.setLatLng(latlng);
                    } else {
                        marker = L.marker(latlng, { draggable: true }).addTo(map);
                        marker.on('dragend', function(event) {
                            const position = marker.getLatLng();
                            updateLatLng(position.lat, position.lng);
                        });
                    }
                    map.setView(latlng, map.getZoom());
                }
            }

            latInput.addEventListener('input', syncMapFromInputs);
            lngInput.addEventListener('input', syncMapFromInputs);
        });
    </script>
</x-app-layout>
