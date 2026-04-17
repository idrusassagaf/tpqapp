<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class GenderUsiaController extends Controller
{
    // Tampilkan data Gender & Usia
    public function index(Request $request)
    {
        $search = $request->search;
        $gender = $request->gender;

        $santris = Santri::when($search, function ($q) use ($search) {
            $q->where('nama', 'like', "%$search%")
                ->orWhere('nis', 'like', "%$search%");
        })
            ->when($gender, function ($q) use ($gender) {
                $q->where('jk', $gender);
            })
            ->orderBy('nama')
            ->get();

        return view('admin.gender-usia.index', compact('santris', 'search', 'gender'));
    }


    // Update Tanggal Lahir
    public function update(Request $request, Santri $santri)
    {
        $request->validate([
            'tgl_lahir' => 'nullable|date'
        ]);

        $santri->update([
            'tgl_lahir' => $request->tgl_lahir
        ]);

        return back()->with('success', 'Tanggal Lahir berhasil disimpan');
    }

    // Reset Tanggal Lahir
    public function destroy(Santri $santri)
    {
        $santri->update([
            'tgl_lahir' => null
        ]);

        return back()->with('success', 'Tanggal Lahir dihapus');
    }
    public function exportPdf(Request $request)
    {
        $search = $request->search;
        $gender = $request->gender;

        $santris = Santri::when($search, function ($q) use ($search) {
            $q->where('nama', 'like', "%$search%")
                ->orWhere('nis', 'like', "%$search%");
        })
            ->when($gender, function ($q) use ($gender) {
                $q->where('jk', $gender);
            })
            ->orderBy('nama')
            ->get();

        Carbon::setLocale('id');
        $tanggal = Carbon::now()->translatedFormat('d F Y');

        $pdf = Pdf::loadView('admin.gender-usia.pdf', [
            'judul'    => 'Laporan Gender & Usia Santri',
            'santris'  => $santris,
            'tanggal'  => $tanggal,
            'search'   => $search,
            'gender'   => $gender
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan-gender-usia-santri.pdf');
    }
}
