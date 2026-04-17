<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orangtua;

class OrangtuaAlamatKontakController extends Controller
{
    // Tampilkan halaman alamat & kontak
    public function index(Request $request)
    {
        $query = Orangtua::select('id', 'nama_ayah', 'nama_ibu', 'alamat', 'no_kontak');

        // Search Nama Ayah/Ibu
        if ($request->search_nama) {
            $query->where('nama_ayah', 'like', '%' . $request->search_nama . '%')
                ->orWhere('nama_ibu', 'like', '%' . $request->search_nama . '%');
        }

        // Search Alamat
        if ($request->search_alamat) {
            $query->where('alamat', 'like', '%' . $request->search_alamat . '%');
        }

        $orangtuas = $query->orderBy('nama_ayah')->get();

        return view('admin.orangtua.alamat-kontak', compact('orangtuas'));
    }

    // Update alamat / no_kontak via AJAX
    public function updateAlamat(Request $request, $id)
    {
        $ortu = OrangTua::findOrFail($id);

        $ortu->alamat = $request->alamat ?? $ortu->alamat;
        $ortu->no_kontak = $request->no_kontak ?? $ortu->no_kontak;

        $ortu->save();

        return response()->json(['success' => true]);
    }
}
