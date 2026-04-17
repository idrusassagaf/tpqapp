<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class GuruKelahiranUsiaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $gender = $request->gender;

        $gurus = Guru::query()
            ->when($search, function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nig', 'like', "%{$search}%");
            })
            ->when($gender, function ($q) use ($gender) {
                $q->where('jenis_kelamin', $gender);
            })
            ->orderBy('nama', 'asc')
            ->get();

        // WAJIB mengarah ke folder Guru
        return view('admin.Guru.kelahiran-usia', compact('gurus', 'search', 'gender'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'tgl_lahir' => 'required|date',
        ]);

        $guru->update([
            'tgl_lahir' => $request->tgl_lahir,
            'tempat_lahir' => $request->tempat_lahir
        ]);

        return back()->with('success', 'Tanggal lahir guru berhasil disimpan.');
    }

    public function destroy(Guru $guru)
    {
        $guru->update([
            'tgl_lahir' => null,
        ]);

        return back()->with('success', 'Tanggal lahir guru berhasil direset.');
    }

    public function exportPdf()
    {
        $gurus = Guru::orderBy('nama', 'asc')->get();

        // Format tanggal Indonesia
        Carbon::setLocale('id');
        $tanggal = now()->translatedFormat('d F Y');

        $pdf = Pdf::loadView('admin.Guru.kelahiran-usia-pdf', [
            'judul'   => 'Laporan Data Kelahiran & Usia Guru',
            'gurus'   => $gurus,
            'tanggal' => $tanggal
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan-kelahiran-usia-guru.pdf');
    }
}
