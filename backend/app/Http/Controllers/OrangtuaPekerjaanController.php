<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orangtua;

class OrangtuaPekerjaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Orangtua::select(
            'id',
            'nama_ayah',
            'nama_ibu',
            'pekerjaan_ayah',
            'pekerjaan_ibu'
        );

        // Search Nama Ayah/Ibu
        if ($request->search_nama) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_ayah', 'like', '%' . $request->search_nama . '%')
                    ->orWhere('nama_ibu', 'like', '%' . $request->search_nama . '%');
            });
        }

        // Search Pekerjaan
        if ($request->search_pekerjaan) {
            $query->where(function ($q) use ($request) {
                $q->where('pekerjaan_ayah', 'like', '%' . $request->search_pekerjaan . '%')
                    ->orWhere('pekerjaan_ibu', 'like', '%' . $request->search_pekerjaan . '%');
            });
        }

        $orangtuas = $query->orderBy('nama_ayah')->get();

        return view('admin.Orangtua.pekerjaan', compact('orangtuas'));
    }

    // Update pekerjaan ayah/ibu via AJAX
    public function updatePekerjaan(Request $request, $id)
    {
        $ortu = Orangtua::findOrFail($id);

        $ortu->pekerjaan_ayah = $request->pekerjaan_ayah;
        $ortu->pekerjaan_ibu = $request->pekerjaan_ibu;
        $ortu->save();

        return response()->json(['success' => true]);
    }
}
