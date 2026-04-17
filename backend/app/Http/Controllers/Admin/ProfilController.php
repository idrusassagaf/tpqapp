<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{

    public function index()
    {
        $path = storage_path('app/profil.json');

        if (file_exists($path)) {
            $profil = json_decode(file_get_contents($path), true);
        } else {
            $profil = [];
        }

        return view('admin.profil.index', compact('profil'));
    }


    public function update(Request $request)
    {
        $path = storage_path('app/profil.json');

        if (file_exists($path)) {
            $profil = json_decode(file_get_contents($path), true);
        } else {
            $profil = [];
        }

        $data = [
            'sejarah' => $request->sejarah,
            'visi' => $request->visi,
            'misi' => $request->misi,
            'tujuan' => $request->tujuan,
            'lokasi' => $request->lokasi,
        ];

        $fotoFields = ['pembina', 'ketua', 'sekretaris', 'bendahara', 'staf1', 'staf2'];

        foreach ($fotoFields as $field) {

            if ($request->hasFile($field)) {

                $file = $request->file($field);

                $namaFile = $field . '_' . time() . '.' . $file->getClientOriginalExtension();

                $file->move(public_path('images/pimpinan'), $namaFile);

                $data[$field] = $namaFile;
            } else {

                if (isset($profil[$field])) {
                    $data[$field] = $profil[$field];
                }
            }

            // 🔵 TAMBAHKAN 2 BARIS INI
            $data[$field . '_nama'] = $request->input($field . '_nama');
            $data[$field . '_jabatan'] = $request->input($field . '_jabatan');
        }

        file_put_contents(
            $path,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
