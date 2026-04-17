<?php

namespace App\Http\Controllers;

use App\Models\ProgresAlquran;
use App\Models\Santri;
use App\Models\Guru;
use Illuminate\Http\Request;

class ProgresAlquranController extends Controller
{
    public function index(Request $request)
    {
        // =========================
        // QUERY SANTRI (AL QURAN)
        // =========================
        $query = Santri::with('guru')
            ->where('kelas', 'Al Quran');

        // SEARCH NAMA SANTRI
        if ($request->filled('q')) {
            $query->where('nama', 'like', '%' . $request->q . '%');
        }

        // FILTER GURU
        if ($request->filled('guru')) {
            $query->where('guru_id', $request->guru);
        }

        // FILTER PROGRES (Lanjut/Ulang)
        // Lanjut  = progres_alqurans.progres = "Sudah LCR"
        // Ulang   = progres_alqurans.progres = "Belum LCR"
        if ($request->filled('ulang_lanjut')) {

            $target = null;
            if ($request->ulang_lanjut === 'Lanjut') $target = 'Sudah LCR';
            if ($request->ulang_lanjut === 'Ulang')  $target = 'Belum LCR';

            if ($target) {
                $query->whereHas('progresAlquran', function ($q) use ($target) {
                    $q->where('progres', $target);
                });
            }
        }

        $santris = $query->orderBy('nama')->get();

        // =========================
        // PROGRES MAP (UNTUK VIEW)
        // =========================
        $progresList = ProgresAlquran::all();

        $progresMap = [];
        foreach ($progresList as $p) {
            $progresMap[$p->santri_id] = $p;
        }

        $guruList = Guru::orderBy('nama')->get();

        return view('admin.laporan.progres-alquran', compact('santris', 'progresMap', 'guruList'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'juz' => 'nullable|string',
            'hal' => 'nullable|string',
            'progres' => 'nullable|string',
            'santri_id' => 'required|integer',
            'guru_id' => 'nullable|integer',
        ]);

        $progres = ProgresAlquran::find($id);

        if (!$progres) {
            $progres = ProgresAlquran::create([
                'santri_id' => $data['santri_id'],
                'guru_id'   => $data['guru_id'],
                'juz'       => $data['juz'],
                'hal'       => $data['hal'],
                'progres'   => $data['progres'],
            ]);
        } else {
            $progres->update([
                'juz'     => $data['juz'],
                'hal'     => $data['hal'],
                'progres' => $data['progres'],
            ]);
        }

        return response()->json([
            'success' => true,
            'id' => $progres->id
        ]);
    }
}
