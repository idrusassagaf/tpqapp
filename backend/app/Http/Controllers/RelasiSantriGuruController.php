<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Guru;
use Illuminate\Http\Request;

class RelasiSantriGuruController extends Controller
{
    // Halaman relasi Santri + Guru
    public function index(Request $request)
    {
        $search = $request->get('search');

        $santris = Santri::with('guru')
            ->when($search, fn($q) => $q->where('nama', 'like', "%$search%"))
            ->orderBy('kelas')
            ->get();

        $gurus = Guru::orderBy('nama')->get();

        return view('admin.relasi.santri-guru', compact('santris', 'gurus', 'search'));
    }

    // Update kelas + guru via AJAX
    public function updateGuru(Request $request)
    {
        $santri = Santri::find($request->santri_id);
        if ($santri) {
            $santri->kelas = $request->kelas;
            $santri->guru_id = $request->guru_id;
            $santri->save();

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
}
