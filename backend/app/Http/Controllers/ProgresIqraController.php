<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgresIqraController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;
        $iqra = $request->iqra;
        $guru = $request->guru;
        $ulang_lanjut = $request->ulang_lanjut;

        $santris = Santri::query()
            ->with('guru')
            ->leftJoin('progres_iqras', 'santris.id', '=', 'progres_iqras.santri_id')
            ->where('santris.kelas', 'like', 'Iqra%')

            ->when($q, function ($query) use ($q) {
                $query->where('santris.nama', 'like', "%{$q}%");
            })

            ->when($iqra, function ($query) use ($iqra) {
                $query->where('santris.kelas', $iqra);
            })

            ->when($guru, function ($query) use ($guru) {
                $query->where('santris.guru_id', $guru);
            })

            // FIX UTAMA: ulang/lanjut dihitung otomatis walaupun progres null
            ->when($ulang_lanjut, function ($query) use ($ulang_lanjut) {
                $query->whereRaw("
                CASE
                    WHEN progres_iqras.status = 'Lancar' THEN 'Lanjut'
                    ELSE 'Ulang'
                END = ?
            ", [$ulang_lanjut]);
            })

            ->select('santris.*')
            ->orderBy('santris.nama', 'asc')
            ->get();

        $progresMap = DB::table('progres_iqras')->get()->keyBy('santri_id');
        $guruList = Guru::orderBy('nama')->get();

        return view('admin.laporan.progres-iqra', compact('santris', 'progresMap', 'guruList'));
    }


    public function update(Request $request, Santri $santri)
    {
        $request->validate([
            'hal' => 'nullable|integer|min:1|max:400',
            'status' => 'required|in:Lancar,Belum Lancar',
        ]);

        $ulang_lanjut = $request->status === 'Lancar' ? 'Lanjut' : 'Ulang';

        // Ambil nomor iqra dari kelas santri (contoh: "Iqra 3" => 3)
        $kelas = $santri->kelas ?? '';
        $iqraNumber = null;

        if (str_starts_with($kelas, 'Iqra ')) {
            $iqraNumber = (int) str_replace('Iqra ', '', $kelas);
        }

        DB::table('progres_iqras')->updateOrInsert(
            ['santri_id' => $santri->id],
            [
                'iqra' => $iqraNumber,
                'hal' => $request->hal,
                'status' => $request->status,
                'ulang_lanjut' => $ulang_lanjut,
                'updated_at' => now(),
            ]
        );

        return redirect()->route('laporan.progres-iqra', request()->query())
            ->with('success', 'Progres berhasil disimpan.');
    }
}
