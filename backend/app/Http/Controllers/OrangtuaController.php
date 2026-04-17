<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Orangtua;
use Illuminate\Http\Request;

class OrangtuaController extends Controller
{
    /**
     * Tampilkan data Status Orang Tua berdasarkan Santri
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $statusFilter = $request->status;

        $santris = Santri::with('orangtua')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('nama', 'like', "%{$search}%")
                        ->orWhereHas('orangtua', function ($oq) use ($search) {
                            $oq->where('nama_ayah', 'like', "%{$search}%")
                                ->orWhere('nama_ibu', 'like', "%{$search}%");
                        });
                });
            })
            ->when($statusFilter, function ($q) use ($statusFilter) {
                $q->whereHas('orangtua', function ($oq) use ($statusFilter) {
                    $oq->where('status_orangtua', $statusFilter);
                });
            })
            ->orderBy('nama')
            ->get();

        return view('admin.orangtua.index', compact('santris', 'search', 'statusFilter'));
    }

    /**
     * Update Status Orang Tua Inline
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status_orangtua' => 'required|string|max:255',
        ]);

        $orangtua = Orangtua::findOrFail($id);

        $orangtua->status_orangtua = $request->status_orangtua;
        $orangtua->save();

        // 🔥 AUTO UPDATE KE SANTRI
        // 🔥 mapping status (SAMAKAN DENGAN PENDAFTARAN)
        $statusSantri = match ($request->status_orangtua) {
            'Keduanya Hidup' => 'Santunan Orangtua',
            'Keduanya Wafat' => 'Yatim Piatu',
            'Ayah Wafat' => 'Yatim',
            'Ibu Wafat' => 'Piatu',
            default => 'Santunan Orangtua'
        };

        // 🔥 ambil santri dari relasi
        if ($orangtua->santri) {
            $orangtua->santri->update([
                'status_santri' => $statusSantri
            ]);
        }

        return back()->with('success', 'Status Orang Tua berhasil diupdate.');
    }

    public function updateAlamat(Request $request, $id)
    {
        $ortu = OrangTua::findOrFail($id);
        $ortu->alamat = $request->alamat;
        $ortu->save();

        return response()->json(['success' => true]);
    }
    public function edit(Orangtua $orangtua)
    {
        $statusList = [
            'Ayah Wafat',
            'Ibu Wafat',
            'Keduanya Hidup',
            'Keduanya Wafat',
        ];

        return view('admin.orangtua.edit', compact('orangtua', 'statusList'));
    }
}
