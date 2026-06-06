<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $kriterias = Kriteria::orderBy('kode', 'asc')->get();

        return view('admin.kriteria.index', compact('kriterias'));
    }

    /**
     * Update the specified resources in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kriteria' => 'required|array',
            'kriteria.*.bobot' => 'required|numeric|min:0',
            'kriteria.*.tipe' => 'required|in:cost,benefit',
        ]);

        foreach ($validated['kriteria'] as $id => $data) {
            $kriteria = Kriteria::findOrFail($id);
            $kriteria->update([
                'bobot' => $data['bobot'],
                'tipe' => $data['tipe'],
            ]);
        }

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Bobot dan tipe kriteria berhasil diperbarui.');
    }
}
