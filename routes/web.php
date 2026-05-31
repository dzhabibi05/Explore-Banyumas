<?php

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
    $kategori = request('kategori', 'all');
    $page = request('page', 1);

    $cacheKey = "destinasi_{$kategori}_page_{$page}";

    $data = Cache::remember($cacheKey, now()->addHours(24), function () use ($kategori) {
        $query = Wisata::query();

        if (in_array($kategori, ['Alam', 'Buatan', 'Budaya'])) {
            $query->where('kategori', $kategori);
        }

        $paginator = $query->latest()->paginate(6);

        return [
            'items' => $paginator->getCollection()->toArray(),
            'total' => $paginator->total(),
            'perPage' => $paginator->perPage(),
            'currentPage' => $paginator->currentPage(),
        ];
    });

    // Hidrasi kembali data array mentah menjadi objek model Wisata
    $items = Wisata::hydrate($data['items'])->all();

    $destinasi = new LengthAwarePaginator(
        $items,
        $data['total'],
        $data['perPage'],
        $data['currentPage'],
        [
            'path' => request()->url(),
            'query' => request()->query(),
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

// Contoh Area Khusus Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
