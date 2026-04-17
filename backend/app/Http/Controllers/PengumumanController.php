<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        $pengumuman = Pengumuman::when($q, function ($query) use ($q) {
            $query->where('judul', 'like', "%$q%")
                ->orWhere('isi', 'like', "%$q%");
        })
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.informasi.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('admin.informasi.pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'nullable|date',
            'isi' => 'required|string',
            'status' => 'required|string',
        ]);

        Pengumuman::create([
            'judul' => $request->judul,
            'tanggal' => $request->tanggal,
            'isi' => $request->isi,
            'status' => $request->status,
        ]);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('admin.informasi.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'nullable|date',
            'isi' => 'required|string',
            'status' => 'required|string',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);

        $pengumuman->update([
            'judul' => $request->judul,
            'tanggal' => $request->tanggal,
            'isi' => $request->isi,
            'status' => $request->status,
        ]);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diupdate.');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function publicIndex()
    {
        $pengumumans = \App\Models\Pengumuman::latest()->get();

        return view('public.pengumuman.index', compact('pengumumans'));
    }
    public function showPublic($id)
    {
        $pengumuman = \App\Models\Pengumuman::findOrFail($id);

        return view('public.pengumuman.show', compact('pengumuman'));
    }
}
