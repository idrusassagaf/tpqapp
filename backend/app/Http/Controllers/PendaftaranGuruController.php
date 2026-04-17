<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendaftaranGuruController extends Controller
{
    private $mapelList = [
        'Al Quran',
        'Iqra 1',
        'Iqra 2',
        'Iqra 3',
        'Iqra 4',
        'Iqra 5',
        'Iqra 6',
        'Iqra 7',
        'Iqra 8'
    ];

    // ===============================
    // FORM PENDAFTARAN GURU
    // ===============================
    public function index()
    {
        // NIG random 4 digit + unik
        do {
            $nig = mt_rand(1000, 9999);
        } while (Guru::where('nig', $nig)->exists());

        return view('admin.pendaftaran-guru.index', [
            'nig' => $nig,
            'mapelList' => $this->mapelList
        ]);
    }

    // ===============================
    // SIMPAN PENDAFTARAN GURU
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nig' => 'required|unique:gurus,nig',
            'jenis_kelamin' => 'required|in:L,P',
            'mapel' => 'required|in:' . implode(',', $this->mapelList),

            'tempat_lahir' => 'nullable|string|max:100',
            'tgl_lahir' => 'nullable|date',
            'no_kontak' => 'nullable|string|max:12',
            'pendidikan' => 'nullable|string|max:100',
            'alamat' => 'nullable|string|max:500',

            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nig.required' => 'NIG wajib diisi.',
            'nig.unique' => 'NIG sudah digunakan.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'mapel.required' => 'Mapel wajib dipilih.',
            'mapel.in' => 'Mapel tidak valid.',
            'foto.image' => 'Foto harus berupa gambar.',
            'foto.mimes' => 'Foto harus format jpg/jpeg/png/webp.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        $data = $request->only([
            'nama',
            'nig',
            'jenis_kelamin',
            'mapel',
            'tempat_lahir',
            'tgl_lahir',
            'no_kontak',
            'pendidikan',
            'alamat'
        ]);

        // Upload foto
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('guru', 'public');
        }

        Guru::create($data);

        return redirect()
            ->route('pendaftaran-guru.index')
            ->with('success', 'Pendaftaran guru berhasil disimpan.');
    }

    // ===============================
    // (OPTIONAL) HAPUS FOTO GURU
    // ===============================
    public function deleteFoto(Guru $guru)
    {
        if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->update(['foto' => null]);

        return back()->with('success', 'Foto guru berhasil dihapus.');
    }
}
