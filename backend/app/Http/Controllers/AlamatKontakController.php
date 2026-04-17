<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrangTua;

class AlamatKontakController extends Controller
{
    public function index(Request $request)
    {
        $query = OrangTua::query();

        if ($request->search_nama) {
            $query->where('nama_ayah', 'like', '%' . $request->search_nama . '%')
                ->orWhere('nama_ibu', 'like', '%' . $request->search_nama . '%');
        }

        if ($request->search_alamat) {
            $query->where('alamat', 'like', '%' . $request->search_alamat . '%');
        }

        $orangtuas = $query->get();

        return view('admin.orangtua.alamat-kontak', compact('orangtuas'));
    }

    public function updateAlamat(Request $request, $id)
    {
        $ortu = OrangTua::findOrFail($id);
        $ortu->alamat = $request->alamat;
        $ortu->save();

        return response()->json(['success' => true]);
    }
}
