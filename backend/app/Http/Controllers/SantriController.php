<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Santri;
use Carbon\Carbon;

class SantriController extends Controller
{
    // LIST SANTRI + filter + pagination
    public function index(Request $request)
    {
        $search = $request->query('search');
        $kelasFilter = $request->query('kelas');
        $jkFilter = $request->query('jk');
        $perPage = $request->query('per_page', 10);

        $query = Santri::query();
        if ($search) $query->where('nama', 'like', "%{$search}%");
        if ($kelasFilter) $query->where('kelas', $kelasFilter);
        if ($jkFilter) $query->where('jk', $jkFilter);

        $santris = $query->orderBy('nama')->paginate($perPage)->withQueryString();

        $kelasList = ['Al Quran', 'Iqra 1', 'Iqra 2', 'Iqra 3', 'Iqra 4', 'Iqra 5', 'Iqra 6', 'Iqra 7', 'Iqra 8'];

        return view('admin.Santri.index', compact('santris', 'kelasList', 'search', 'kelasFilter', 'jkFilter', 'perPage'));
    }

    // FORM TAMBAH
    public function create()
    {
        $kelasList = ['Al Quran', 'Iqra 1', 'Iqra 2', 'Iqra 3', 'Iqra 4', 'Iqra 5', 'Iqra 6', 'Iqra 7', 'Iqra 8'];
        do {
            $nis = rand(1000, 9999);
        } while (Santri::where('nis', $nis)->exists());
        return view('admin.Santri.create', compact('kelasList', 'nis'));
    }

    // SIMPAN SANTRI
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:santris,nis',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string',
            'jk' => 'required|in:L,P',
            'foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto_santri', 'public');
        }

        Santri::create($validated);
        return redirect()->route('santri.index')->with('success', 'Santri berhasil ditambahkan!');
    }

    // FORM EDIT
    public function edit(Santri $santri)
    {
        $kelasList = ['Al Quran', 'Iqra 1', 'Iqra 2', 'Iqra 3', 'Iqra 4', 'Iqra 5', 'Iqra 6', 'Iqra 7', 'Iqra 8'];
        return view('admin.Santri.edit', compact('santri', 'kelasList'));
    }

    // UPDATE SANTRI
    public function update(Request $request, Santri $santri)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string',
            'jk' => 'required|in:L,P',
            'foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            // hapus foto lama jika ada
            if ($santri->foto && file_exists(storage_path('app/public/' . $santri->foto))) {
                unlink(storage_path('app/public/' . $santri->foto));
            }

            // simpan foto baru (SAMAKAN DENGAN STORE)
            $validated['foto'] = $request->file('foto')->store('foto_santri', 'public');
        }

        $santri->update($validated);

        return redirect()->route('santri.index')->with('success', 'Data santri berhasil diperbarui!');
    }
    // HAPUS SANTRI
    public function destroy(Santri $santri)
    {
        if ($santri->foto && file_exists(storage_path('app/public/' . $santri->foto))) {
            unlink(storage_path('app/public/' . $santri->foto));
        }
        $santri->delete();
        return redirect()->route('santri.index')->with('success', 'Santri berhasil dihapus!');
    }

    // DETAIL / CV
    public function cv($id)
    {
        $santri = Santri::with(['orangtua', 'progresIqra', 'progresAlquran'])->findOrFail($id);
        return view('santri.cv', compact('santri'));
    }


    // EXPORT PDF DATA SANTRI
    public function exportPdf(Request $request)
    {
        $search = $request->query('search');
        $kelasFilter = $request->query('kelas');
        $jkFilter = $request->query('jk');

        $query = Santri::query();

        if ($search) {
            $query->where('nama', 'like', "%{$search}%");
        }

        if ($kelasFilter) {
            $query->where('kelas', $kelasFilter);
        }

        if ($jkFilter) {
            $query->where('jk', $jkFilter);
        }

        $santris = $query->orderBy('nama')->get();

        Carbon::setLocale('id');
        $tanggal = Carbon::now()->translatedFormat('d F Y');

        $pdf = Pdf::loadView('admin.Santri.pdf', [
            'judul'    => 'Laporan Data Santri',
            'santris'  => $santris,
            'tanggal'  => $tanggal
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan-data-santri.pdf');
    }
}
