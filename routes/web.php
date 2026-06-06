<?php

use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\PenilaianController;
use App\Http\Controllers\Admin\WisataController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekomendasiController;
use App\Models\Wisata;
use App\Services\TopsisService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::post('/rekomendasi', [RekomendasiController::class, 'proses'])->middleware('auth')->name('rekomendasi.proses');

Route::get('/', function () {
    // Ambil parameter dari request
    $kategori = request('kategori', '');
    $page = request('page', 1);

    // Kunci cache unik berdasarkan kategori dan halaman
    $cacheKey = "destinasi_kategori_{$kategori}_page_{$page}";

    // Simpan di Cache selama 24 jam untuk optimasi kecepatan
    $data = Cache::remember($cacheKey, now()->addHours(24), function () use ($kategori) {
        $query = Wisata::query();

        // Filter kategori jika valid
        if (in_array($kategori, ['Alam', 'Buatan', 'Budaya'])) {
            $query->where('kategori', $kategori);
        }

        $paginator = $query->paginate(6);

        return [
            'items' => $paginator->getCollection()->toArray(),
            'total' => $paginator->total(),
            'perPage' => $paginator->perPage(),
            'currentPage' => $paginator->currentPage(),
        ];
    });

    // Hidrasi kembali data array mentah menjadi Collection objek model Wisata
    $items = Wisata::hydrate($data['items'])->all();

    // Buat ulang Instance Paginator manual
    $destinasi = new LengthAwarePaginator(
        $items,
        $data['total'],
        $data['perPage'],
        $data['currentPage'],
        [
            'path' => request()->url(),
            'query' => request()->query(), // <-- INI PENTING AGAR FILTER KATEGORI TIDAK HILANG
        ]
    );

    return view('welcome', compact('destinasi'));
});

// Dashboard Umum (Diakses oleh Wisatawan. Jika Admin mencoba mengakses, dialihkan ke Admin Panel)
Route::get('/dashboard', function (TopsisService $topsisService) {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    $inputs = session('last_topsis_inputs');
    if (! $inputs) {
        return view('dashboard');
    }

    $calculation = $topsisService->hitungRekomendasiLengkap(
        $inputs['latitude'],
        $inputs['longitude'],
        $inputs['kategori']
    );

    $lastTopsis = [
        'nama' => $inputs['nama'],
        'kategori' => $inputs['kategori'],
        'data' => $calculation,
    ];

    return view('dashboard', compact('lastTopsis'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('wisata', WisataController::class)->parameters([
        'wisata' => 'wisata',
    ]);
    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::post('/kriteria', [KriteriaController::class, 'update'])->name('kriteria.update');
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::post('/penilaian', [PenilaianController::class, 'update'])->name('penilaian.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
