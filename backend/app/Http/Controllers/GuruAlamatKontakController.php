<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class GuruAlamatKontakController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $alamat = $request->query('alamat');

        $query = Guru::query();

        // filter search (nama / nig)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nig', 'like', "%{$search}%");
            });
        }

        // filter alamat
        if ($alamat) {
            $query->where('alamat', 'like', "%{$alamat}%");
        }

        // pakai get() saja supaya Total Guru sesuai dan tabel tidak pindah page
        $gurus = $query->orderBy('nama', 'asc')->get();

        return view('admin.guru.alamat-kontak', compact('gurus', 'search', 'alamat'));
    }

    // FIX: route pakai {guru} jadi harus Guru $guru (model binding)
    public function updateAlamatKontak(Request $request, Guru $guru)
    {
        $request->validate([
            'alamat' => 'nullable|string|max:255',
            'no_kontak' => 'nullable|string|max:30',
        ]);

        $guru->alamat = $request->alamat;
        $guru->no_kontak = $request->no_kontak;
        $guru->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ]);
    }
    public function exportAlamatKontakPdf()
    {
        $gurus = Guru::orderBy('nama', 'asc')->get();

        $pdf = Pdf::loadView('admin.guru.alamat-kontak-pdf', [
            'judul' => 'Laporan Alamat & Kontak Guru',
            'gurus' => $gurus
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan-alamat-kontak-guru.pdf');
    }
}
