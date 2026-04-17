<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Schema;

class GuruStatusController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $kehadiran = $request->kehadiran;
        $status = $request->status;

        $gurus = Guru::query()
            ->when($search, function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhere('nig', 'like', "%$search%");
            })
            ->when($kehadiran, function ($q) use ($kehadiran) {
                if (Schema::hasColumn('gurus', 'kehadiran')) {
                    $q->where('kehadiran', $kehadiran);
                }
            })
            ->when($status, function ($q) use ($status) {
                if (Schema::hasColumn('gurus', 'status_guru')) {
                    $q->where('status_guru', $status);
                }
            })
            ->orderBy('nama', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.guru.status', compact('gurus'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Validasi input
        $rules = ['kehadiran' => 'required|string'];
        if ($request->has('no_kontak')) {
            $rules['no_kontak'] = 'digits:8';
        }
        $request->validate($rules);

        $guru = Guru::findOrFail($id);

        $kehadiran = $request->kehadiran;

        // Status otomatis berdasarkan kehadiran
        $status = '-';
        if ($kehadiran === 'Alpa < 5 Hr') {
            $status = 'Aktif';
        } elseif ($kehadiran === 'Alpa < 10 Hr') {
            $status = 'Kurang Aktif';
        } elseif ($kehadiran === 'Alpa > 10 Hr') {
            $status = 'Tidak Aktif';
        }

        // Update hanya jika kolom ada
        if (Schema::hasColumn('gurus', 'kehadiran')) {
            $guru->kehadiran = $kehadiran;
        }

        if (Schema::hasColumn('gurus', 'status_guru')) {
            $guru->status_guru = $status;
        }

        // Update kontak jika input ada
        if ($request->has('no_kontak')) {
            $guru->no_kontak = $request->no_kontak;
        }
        try {
            $guru->save();

            return response()->json([
                'success' => true,
                'status' => $status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal update data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportPdf()
    {
        $gurus = Guru::orderBy('nama', 'asc')->get();
        $tanggal = now()->format('d F Y');
        $judul = "LAPORAN DATA STATUS GURU";

        $pdf = Pdf::loadView(
            'admin.guru.status-pdf',
            compact('gurus', 'tanggal', 'judul')
        );

        return $pdf->download('laporan_status_guru.pdf');
    }
}
