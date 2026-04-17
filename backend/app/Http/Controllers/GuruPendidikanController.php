<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class GuruPendidikanController extends Controller
{
    public function index(Request $request)
    {
        $searchNama = $request->search_nama;
        $searchPendidikan = $request->search_pendidikan;

        $gurus = Guru::query()
            ->when($searchNama, function ($q) use ($searchNama) {
                $q->where(function ($sub) use ($searchNama) {
                    $sub->where('nama', 'like', "%$searchNama%")
                        ->orWhere('nig', 'like', "%$searchNama%");
                });
            })
            ->when($searchPendidikan, function ($q) use ($searchPendidikan) {
                $q->where('pendidikan', 'like', "%$searchPendidikan%");
            })
            ->orderBy('nama', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.guru.pendidikan', compact('gurus'));
    }

    public function updatePendidikan(Request $request, $id)
    {
        $request->validate([
            'pendidikan' => 'nullable|string|max:100',
        ]);

        $guru = Guru::findOrFail($id);

        $guru->pendidikan = $request->pendidikan;
        $guru->save();

        return response()->json([
            'success' => true
        ]);
    }
    public function exportPdf()
    {
        $gurus = Guru::orderBy('nama', 'asc')->get();

        $pdf = Pdf::loadView('admin.guru.pendidikan-pdf', [
            'judul' => 'Laporan Pendidikan Guru',
            'gurus' => $gurus
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan-pendidikan-guru.pdf');
    }
}
