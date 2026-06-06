<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Wisata;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $kriterias = Kriteria::whereIn('kode', ['C2', 'C3', 'C4'])->orderBy('kode', 'asc')->get();

        $search = $request->input('search');

        $wisatas = Wisata::with(['penilaian'])
            ->when($search, function ($query, $search) {
                return $query->where('nama_wisata', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        // Pre-map the ratings to make view loading fast and clean
        foreach ($wisatas as $wisata) {
            $mapped = [];
            foreach ($wisata->penilaian as $p) {
                $mapped[$p->kriteria_id] = $p->nilai;
            }
            $wisata->mapped_penilaian = $mapped;
        }

        return view('admin.penilaian.index', compact('wisatas', 'kriterias', 'search'));
    }

    /**
     * Update the specified resources in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'penilaian' => 'required|array',
            'penilaian.*' => 'required|array',
            'penilaian.*.*' => 'required|numeric|min:0',
        ]);

        foreach ($validated['penilaian'] as $wisataId => $kriteriaValues) {
            foreach ($kriteriaValues as $kriteriaId => $nilai) {
                $kriteria = Kriteria::findOrFail($kriteriaId);

                // Formatter / Validator per kriteria
                if ($kriteria->kode === 'C3') {
                    // Rating: Skala desimal 1.0 - 5.0
                    $nilai = max(1.0, min(5.0, floatval($nilai)));
                } elseif ($kriteria->kode === 'C4') {
                    // Fasilitas: Skala poin kelengkapan 1 - 5 (or similar)
                    $nilai = max(1, intval($nilai));
                } else {
                    // Harga Tiket C2: Nominal rupiah
                    $nilai = floatval($nilai);
                }

                Penilaian::updateOrCreate(
                    [
                        'wisata_id' => $wisataId,
                        'kriteria_id' => $kriteriaId,
                    ],
                    [
                        'nilai' => $nilai,
                    ]
                );
            }
        }

        // Clear cache so any updated recommendations reflect instantly on pages
        Wisata::clearCache();

        return redirect()->route('admin.penilaian.index')
            ->with('success', 'Matriks penilaian berhasil diperbarui.');
    }
}
