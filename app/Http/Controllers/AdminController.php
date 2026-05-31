<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\User;
use App\Models\Wisata;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'total_wisata' => Wisata::count(),
            'total_kriteria' => Kriteria::count(),
            'total_users' => User::count(),
            'total_penilaian' => Penilaian::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
