# 🌿 Explore Banyumas - Sistem Pendukung Keputusan (SPK) Rekomendasi Wisata (TOPSIS)

**Explore Banyumas** adalah aplikasi Sistem Pendukung Keputusan (SPK) berbasis web yang dirancang untuk memberikan rekomendasi destinasi wisata di Kabupaten Banyumas secara objektif dan akurat berdasarkan preferensi wisatawan. Sistem ini mengadopsi metode **TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution)**.

---

## 🎯 Penjelasan Sistem & Cara Kerja TOPSIS

Sistem ini memproses perankingan tempat pariwisata berdasarkan **4 Kriteria Utama**:
1. **C1 - Jarak (Cost)**: Jarak antara titik lokasi saat ini wisatawan (didapat melalui GPS/Peta) ke koordinat tempat wisata. (Dihitung otomatis).
2. **C2 - Harga Tiket Masuk (Cost)**: Nominal tiket masuk dalam Rupiah.
3. **C3 - Rating (Benefit)**: Skala penilaian dari 1.0 sampai 5.0.
4. **C4 - Kelengkapan Fasilitas (Benefit)**: Skala kelengkapan poin fasilitas dari 1 sampai 5.

### Alur Kerja Algoritma:
1. **Input Wisatawan**: Wisatawan memasukkan lokasi geografisnya (GPS/Manual) dan memilih kategori pariwisata (Alam, Buatan, atau Budaya).
2. **Kalkulasi Jarak (C1)**: Program mendeteksi jarak berkendara riil menggunakan **OSRM API**. Jika API gagal/timeout, sistem secara otomatis beralih menggunakan rumus **Haversine Formula** (jarak lurus koordinat bumi).
3. **Pembentukan Matriks Keputusan ($X$)**: Menarik data alternatif pariwisata yang sesuai dari database beserta nilai performa (C2, C3, C4) dan menggabungkannya dengan jarak C1 yang telah dikalkulasi.
4. **Normalisasi Matriks ($R$)**: Menyamakan skala nilai dengan membagi tiap elemen matriks keputusan dengan akar jumlah kuadrat kriteria masing-masing.
5. **Matriks Ternormalisasi Terbobot ($Y$)**: Mengalikan matriks normalisasi ($R$) dengan bobot kriteria masing-masing yang dapat diatur admin.
6. **Solusi Ideal Positif ($A^+$) & Negatif ($A^-$)**: Menentukan performa terbaik dan terburuk untuk setiap kriteria.
7. **Jarak Solusi Ideal ($D^+$ & $D^-$)**: Mengukur jarak Euclidean setiap tempat pariwisata terhadap solusi acuan terbaik ($D^+$) dan terburuk ($D^-$).
8. **Nilai Preferensi Akhir ($V_i$)**: Menghitung kedekatan relatif alternatif menggunakan rumus:
   $$V_i = \frac{D^-_i}{D^-_i + D^+_i}$$
   Nilai $V_i$ berkisar antara 0 sampai 1. Semakin mendekati 1, semakin disarankan tempat wisata tersebut.

---

## 💻 Tech Stack yang Dibutuhkan

* **Bahasa Pemrograman**: PHP >= 8.3 & JavaScript (ES6)
* **Framework Backend**: Laravel 11 / 13
* **CSS Framework**: Tailwind CSS v4 (Desain Responsif & Premium)
* **JS Library**: Alpine.js (State Management komponen UI), Leaflet.js (Peta Interaktif)
* **Database**: MySQL / MariaDB
* **API Pihak Ketiga**: OpenStreetMap & OSRM API (Kalkulasi Jarak Rute Berkendara)
* **Paket Tambahan**: Laravel Breeze (Autentikasi & Manajemen Sesi)

---

## 📂 Struktur Folder Utama Proyek

```text
projectSPK/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                # Controller Panel Kontrol Admin (Wisata, Kriteria, Penilaian)
│   │   │   ├── AdminController.php   # Controller Statistik Utama Admin
│   │   │   └── RekomendasiController # Controller Pemicu TOPSIS dari Landing Page
│   │   └── Middleware/               # Middleware Hak Akses (Role: Admin vs Wisatawan)
│   ├── Models/                       # Model Database (Wisata, Kriteria, Penilaian, User)
│   └── Services/
│       └── TopsisService.php         # Core Engine Algoritma Perhitungan TOPSIS & Jarak
├── config/                           # Konfigurasi Aplikasi Laravel
├── database/
│   ├── migrations/                   # Skema Migrasi Tabel Database
│   └── seeders/                      # Data Seeder Awal (Kriteria, Tempat Wisata, Akun Pengguna)
├── public/                           # Aset Statis (Gambar Logo, Ornamen, File Foto yang Diunggah)
├── resources/
│   ├── css/
│   │   └── app.css                   # Entry Point Tailwind CSS
│   ├── js/
│   │   └── app.js                    # Entry Point Laravel Vite JS
│   └── views/                        # Template Blade HTML
│       ├── admin/                    # View Panel Admin (CRUD Wisata, Bobot Kriteria, Matrix Editor)
│       ├── auth/                     # View Login, Register, Lupa Password
│       ├── layouts/                  # Layout Navigasi & Kerangka HTML Utama
│       ├── dashboard.blade.php       # Dashboard Perhitungan Detail TOPSIS Pengguna
│       ├── hasil.blade.php           # Hasil List Rekomendasi Destinasi Wisata
│       └── welcome.blade.php         # Landing Page Utama Aplikasi
├── routes/
│   └── web.php                       # Definisi Seluruh Rute URL Aplikasi
└── storage/                          # Folder Upload Gambar Pariwisata (public/wisata)
```

---

## 🛠️ Cara Penginstalan (Installation Guide)

Pilih salah satu metode instalasi di bawah ini sesuai dengan lingkungan server lokal yang Anda gunakan:

### Opsi A: Menggunakan XAMPP atau Laragon (Server Lokal)

Ikuti langkah-langkah urut berikut jika Anda mendeploy proyek di dalam server lokal XAMPP atau Laragon:

#### 1. Letakkan Folder Proyek di Direktori Web Server
* **Laragon**: Kloning atau pindahkan folder proyek ini ke `C:\laragon\www\projectSPK`.
* **XAMPP**: Kloning atau pindahkan folder proyek ini ke `C:\xampp\htdocs\projectSPK`.

#### 2. Kloning Repositori
```bash
git clone https://github.com/dzhabibi05/Explore-Banyumas.git
cd Explore-Banyumas
```

#### 3. Aktifkan Apache & MySQL
* Buka **Laragon** atau **XAMPP Control Panel**.
* Klik tombol **Start / Start All** untuk menjalankan layanan **Apache** dan **MySQL**.

#### 4. Pasang Dependensi Proyek
Buka terminal (Command Prompt / Git Bash) di dalam direktori folder proyek Anda (`C:\laragon\www\projectSPK` atau `C:\xampp\htdocs\projectSPK`), lalu jalankan:
```bash
composer install
npm install
```

#### 5. Konfigurasi Lingkungan (.env)
* Salin berkas `.env.example` menjadi `.env`:
  ```bash
  cp .env.example .env
  ```
* Buka file `.env` menggunakan text editor, lalu sesuaikan konfigurasi database MySQL:
  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=db_explore_banyumas
  DB_USERNAME=root
  DB_PASSWORD=
  ```

#### 6. Buat Database Baru
* Buka browser dan akses **phpMyAdmin** (`http://localhost/phpmyadmin`) atau buka **HeidiSQL**.
* Buat database baru bernama **`db_explore_banyumas`**.

#### 7. Jalankan Key Generator, Migrasi, & Seeder Database
Kembali ke terminal proyek Anda, lalu jalankan rentetan perintah berikut secara berurutan:
```bash
php artisan key:generate
php artisan migrate --seed
```
*Perintah ini akan membuat skema tabel dan mengisi data master awal kriteria, destinasi wisata, serta akun admin/wisatawan.*

#### 8. Hubungkan Storage Link
Jalankan perintah berikut agar foto wisata yang diunggah dapat diakses oleh publik:
```bash
php artisan storage:link
```

---

### Opsi B: Menggunakan Laravel Dev Server (PHP CLI)

Ikuti langkah-langkah berikut jika Anda ingin menjalankan aplikasi menggunakan terminal/PHP CLI murni secara independen:

1. **Kloning Proyek**:
   ```bash
   git clone https://github.com/dzhabibi05/Explore-Banyumas.git
   cd Explore-Banyumas
   ```
2. **Install Dependensi**:
   ```bash
   composer install
   npm install
   ```
3. **Setup `.env`**:
   Salin `.env.example` ke `.env` lalu sesuaikan kredensial database SQL Anda.
4. **Key, Migrasi, Seeder, & Storage Link**:
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   php artisan storage:link
   ```

---

## 🚀 Cara Menjalankan Aplikasi

### Jika Menggunakan Opsi A (XAMPP / Laragon):
Aplikasi Anda sudah otomatis dijalankan oleh Apache. Anda hanya perlu membuka browser dan mengakses URL berikut:
* **Laragon**: `http://projectSPK.test` (Laragon Virtual Host otomatis)
* **XAMPP**: `http://localhost/projectSPK/public`
* *Penting: Tetap buka terminal proyek dan jalankan `npm run dev` untuk mengompilasi style Tailwind CSS.*

### Jika Menggunakan Opsi B (PHP CLI):
1. Jalankan server lokal Laravel:
   ```bash
   php artisan serve
   ```
2. Jalankan compiler Vite:
   ```bash
   npm run dev
   ```
3. Buka browser dan akses: `http://127.0.0.1:8000`

---

## 🔑 Akun Pengujian Default (Login Credentials)

Masuk ke panel menggunakan akun hasil *seeding* berikut:

* **Akun Administrator**:
  * Email: `admin@gmail.com`
  * Password: `password`
* **Akun Wisatawan**:
  * Email: `test@example.com`
  * Password: `password`
