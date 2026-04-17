<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\SantriOrangtua;
use App\Models\Orangtua;
use Illuminate\Http\Request;

class RelasiSantriOrangtuaController extends Controller
{
    /**
     * Tampilkan daftar Santri + Wali
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $santris = Santri::with('orangtua')
            ->when($search, function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhereHas('orangtua', function ($q2) use ($search) {
                        $q2->where('nama_ayah', 'like', "%$search%")
                            ->orWhere('nama_ibu', 'like', "%$search%");
                    });
            })
            ->orderBy('nama')
            ->get();

        return view('admin.relasi.santri-orangtua', compact('santris', 'search'));
    }

    /**
     * Simpan / Update data Nama Ayah & Nama Ibu
     * Inline per Santri, otomatis sync ke 2 tabel
     */
    public function store(Request $request, $id)
    {
        // Ambil atau buat record orangtua sesuai santri
        $orangtua = Orangtua::updateOrCreate(
            ['santri_id' => $request->santri_id], // pastikan dikirim
            [
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu
            ]
        );

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }
}
