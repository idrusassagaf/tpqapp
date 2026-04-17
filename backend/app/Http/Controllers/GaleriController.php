<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galeri;
use Illuminate\Support\Facades\Auth;

class GaleriController extends Controller
{
    // =======================
    // INDEX (LIST + FORM)
    // =======================
    public function index()
    {
        if (!in_array(Auth::user()->role, ['super_admin', 'admin'])) {
            abort(403);
        }

        $galeris = Galeri::latest()->get();
        return view('galeri.index', compact('galeris'));
    }

    // =======================
    // STORE (UPLOAD FOTO)
    // =======================
    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['super_admin', 'admin'])) {
            abort(403);
        }

        $request->validate([
            'judul' => 'nullable|string|max:255',
            'foto'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Pastikan folder ada
        $path = public_path('uploads/galeri');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        // Upload file
        $file = $request->file('foto');
        $namaFile = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($path, $namaFile);

        // Simpan ke DB
        Galeri::create([
            'judul' => $request->judul,
            'foto'  => $namaFile
        ]);

        return back()->with('success', 'Foto berhasil diupload');
    }

    // =======================
    // EDIT (FORM EDIT)
    // =======================
    public function edit($id)
    {
        if (!in_array(Auth::user()->role, ['super_admin', 'admin'])) {
            abort(403);
        }

        $galeri = Galeri::findOrFail($id);
        return view('galeri.edit', compact('galeri'));
    }

    // =======================
    // UPDATE (SIMPAN EDIT)
    // =======================
    public function update(Request $request, $id)
    {
        if (!in_array(Auth::user()->role, ['super_admin', 'admin'])) {
            abort(403);
        }

        $galeri = Galeri::findOrFail($id);

        $request->validate([
            'judul' => 'nullable|string|max:255',
            'foto'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Jika upload foto baru
        if ($request->hasFile('foto')) {

            // Hapus foto lama
            $oldPath = public_path('uploads/galeri/' . $galeri->foto);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            // Upload baru
            $file = $request->file('foto');
            $namaFile = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/galeri'), $namaFile);

            $galeri->foto = $namaFile;
        }

        // Update judul
        $galeri->judul = $request->judul;
        $galeri->save();

        return redirect()->route('galeri.index')->with('success', 'Galeri berhasil diupdate');
    }

    // =======================
    // DELETE
    // =======================
    public function destroy($id)
    {
        if (!in_array(Auth::user()->role, ['super_admin', 'admin'])) {
            abort(403);
        }

        $galeri = Galeri::findOrFail($id);

        // Hapus file
        $filePath = public_path('uploads/galeri/' . $galeri->foto);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Hapus DB
        $galeri->delete();

        return back()->with('success', 'Foto berhasil dihapus');
    }
}
