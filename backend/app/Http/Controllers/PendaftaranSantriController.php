<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Orangtua;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PendaftaranSantriController extends Controller
{
    public function index()
    {
        $kelasOptions = [
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

        $statusOrtu = [
            'Keduanya Hidup',
            'Keduanya Wafat',
            'Ayah Wafat',
            'Ibu Wafat'
        ];

        return view('admin.pendaftaran-santri.index', compact('kelasOptions', 'statusOrtu'));
    }

    /**
     * Generate NIS random 4 digit (TPQ-0000) dan pastikan tidak duplikat
     */
    private function generateNisRandom()
    {
        do {
            $angka = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $nis = "TPQ-" . $angka;
        } while (Santri::where('nis', $nis)->exists());

        return $nis;
    }

    public function store(Request $request)
    {
        $request->validate([
            // SANTRI
            'nama' => 'required|string|max:255',
            'jk' => 'required|in:L,P',
            'tgl_lahir' => 'required|date',
            'kelas' => 'required|string|max:50',
            'foto' => 'nullable|image|max:2048',

            // ORANGTUA
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'status_orangtua' => 'required|in:Keduanya Hidup,Keduanya Wafat,Ayah Wafat,Ibu Wafat',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'no_kontak' => 'required|digits_between:10,12',
            'alamat' => 'required|string|max:500',
        ]);

        // Status Santri otomatis berdasarkan status orang tua
        $statusSantri = match ($request->status_orangtua) {
            'Keduanya Hidup' => 'Santunan Orangtua',
            'Keduanya Wafat' => 'Yatim Piatu',
            'Ayah Wafat' => 'Yatim',
            'Ibu Wafat' => 'Piatu',
            default => 'Santunan Orangtua'
        };

        try {

            // ✅ Generate NIS random (tidak berurutan)
            $nis = $this->generateNisRandom();

            DB::transaction(function () use ($request, $statusSantri, $nis) {

                // ======================
                // 1) SIMPAN SANTRI
                // ======================
                $santriData = [
                    'nama' => $request->nama,
                    'jk' => $request->jk,
                    'tgl_lahir' => $request->tgl_lahir,
                    'usia' => Carbon::parse($request->tgl_lahir)->age,
                    'kelas' => $request->kelas,
                    'status_santri' => $statusSantri,
                    'nis' => $nis,
                ];

                if ($request->hasFile('foto')) {
                    $path = $request->file('foto')->store('foto_santri', 'public');
                    $santriData['foto'] = $path;
                }

                $santri = Santri::create($santriData);

                // ======================
                // 2) SIMPAN ORANGTUA
                // ======================
                Orangtua::create([
                    'santri_id' => $santri->id,
                    'nama_ayah' => $request->nama_ayah,
                    'nama_ibu' => $request->nama_ibu,
                    'status_orangtua' => $request->status_orangtua,
                    'pekerjaan_ayah' => $request->pekerjaan_ayah,
                    'pekerjaan_ibu' => $request->pekerjaan_ibu,
                    'no_kontak' => $request->no_kontak,
                    'alamat' => $request->alamat,
                ]);
            });

            return redirect()
                ->route('pendaftaran-santri.index')
                ->with('success', 'Pendaftaran berhasil! Data masuk ke Data Santri & Orang Tua.');
        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
