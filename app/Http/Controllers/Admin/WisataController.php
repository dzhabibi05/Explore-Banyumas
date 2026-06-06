<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Wisata;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WisataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $wisatas = Wisata::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_wisata', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.wisata.index', compact('wisatas', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.wisata.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_wisata' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|in:Alam,Buatan,Budaya',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('wisata', 'public');
        }

        $wisata = Wisata::create($validated);

        // Seed default Penilaian rows for C2, C3, and C4 to prevent TOPSIS calculation error
        $kriterias = Kriteria::whereIn('kode', ['C2', 'C3', 'C4'])->get();
        foreach ($kriterias as $kriteria) {
            $defaultValue = 0;
            if ($kriteria->kode === 'C4') {
                $defaultValue = 1; // Skala fasilitas (1-5)
            } elseif ($kriteria->kode === 'C3') {
                $defaultValue = 1.0; // Skala rating (1.0-5.0)
            }

            Penilaian::create([
                'wisata_id' => $wisata->id,
                'kriteria_id' => $kriteria->id,
                'nilai' => $defaultValue,
            ]);
        }

        return redirect()->route('admin.wisata.index')
            ->with('success', 'Destinasi wisata berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wisata $wisata): View
    {
        return view('admin.wisata.edit', compact('wisata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wisata $wisata): RedirectResponse
    {
        $validated = $request->validate([
            'nama_wisata' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|in:Alam,Buatan,Budaya',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($wisata->foto) {
                Storage::disk('public')->delete($wisata->foto);
            }
            $validated['foto'] = $request->file('foto')->store('wisata', 'public');
        }

        $wisata->update($validated);

        return redirect()->route('admin.wisata.index')
            ->with('success', 'Destinasi wisata berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wisata $wisata): RedirectResponse
    {
        // Delete photo
        if ($wisata->foto) {
            Storage::disk('public')->delete($wisata->foto);
        }

        // Delete pivot penilaian
        $wisata->penilaian()->delete();

        // Delete model
        $wisata->delete();

        return redirect()->route('admin.wisata.index')
            ->with('success', 'Destinasi wisata berhasil dihapus.');
    }
}
