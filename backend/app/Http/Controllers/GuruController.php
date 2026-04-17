<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class GuruController extends Controller
{
    private $mapelList = ['Al Quran', 'Iqra 1', 'Iqra 2', 'Iqra 3', 'Iqra 4', 'Iqra 5', 'Iqra 6', 'Iqra 7', 'Iqra 8'];

    // Daftar Guru
    public function index(Request $request)
    {
        $query = Guru::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->has('mapel') && $request->mapel != '') {
            $query->where('mapel', $request->mapel);
        }

        $gurus = $query->orderBy('nama')->get();

        return view('admin.guru.index', [
            'gurus' => $gurus,
            'mapelList' => $this->mapelList,
            'search' => $request->search,
            'mapelFilter' => $request->mapel
        ]);
    }

    // Form tambah
    public function create()
    {
        $nig = mt_rand(1000, 9999);

        return view('admin.Guru.create', [
            'nig' => $nig,
            'mapelList' => $this->mapelList
        ]);
    }

    // Simpan guru baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nig' => 'required|unique:gurus,nig',
            'jenis_kelamin' => 'required|in:L,P',
            'mapel' => 'required|in:' . implode(',', $this->mapelList),
            'foto' => 'nullable|image|max:2048'
        ]);

        $data = $request->only('nama', 'nig', 'jenis_kelamin', 'mapel');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('guru', 'public');
        }

        Guru::create($data);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    // Form edit
    public function edit(Guru $guru)
    {
        return view('admin.guru.edit', [
            'guru' => $guru,
            'mapelList' => $this->mapelList
        ]);
    }

    // Update guru
    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'mapel' => 'required|in:' . implode(',', $this->mapelList),
            'foto' => 'nullable|image|max:2048'
        ]);

        $data = $request->only('nama', 'jenis_kelamin', 'mapel');

        if ($request->hasFile('foto')) {
            // hapus file lama
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }
            $data['foto'] = $request->file('foto')->store('guru', 'public');
        }

        $guru->update($data);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diupdate.');
    }

    // Hapus guru
    public function destroy(Guru $guru)
    {
        if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->delete();
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
    public function show($id)
    {
        // Bisa redirect saja, karena kita tidak pakai show
        return redirect()->route('guru.index');
    }
    public function alamatKontak(Request $request)
    {
        $query = Guru::query();

        // filter nama / nig
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nig', 'like', "%{$search}%");
            });
        }

        // filter alamat
        if ($request->filled('alamat')) {
            $alamat = $request->alamat;
            $query->where('alamat', 'like', "%{$alamat}%");
        }

        $gurus = $query->orderBy('nama')->get();

        return view('Guru.alamat-kontak', compact('gurus'));
    }

    public function exportPdf()
    {
        $gurus = Guru::all();
        $tanggal = now()->format('d F Y');

        $pdf = Pdf::loadView('admin.Guru.pdf', [
            'judul'   => 'Laporan Data Guru',
            'gurus'   => $gurus,
            'tanggal' => $tanggal
        ]);

        return $pdf->download('data_guru.pdf');
    }
    public function exportKelahiranUsiaPdf()
    {
        $gurus = \App\Models\Guru::all();
        $tanggal = now()->format('d F Y');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'Guru.kelahiran-usia-pdf',
            compact('gurus', 'tanggal')
        );

        return $pdf->download('data_kelahiran_usia_guru.pdf');
    }
}
