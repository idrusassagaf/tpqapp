<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class StatusController extends Controller
{
    public function index(Request $request)
    {
        // ===============================
        // Ambil semua status unik untuk dropdown
        // ===============================
        $allStatuses = Santri::select('status_santri')
            ->whereNotNull('status_santri')
            ->distinct()
            ->orderBy('status_santri')
            ->pluck('status_santri');

        // ===============================
        // Query utama
        // ===============================
        $query = Santri::with('orangtua');

        // Filter nama / NIS
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        // Filter status sosial
        if ($request->filled('status_santri')) {
            $query->where('status_santri', $request->status_santri);
        }

        $santris = $query->orderBy('nama')->get();

        return view('admin.status.index', [
            'santris'      => $santris,
            'search'       => $request->search,
            'statusFilter' => $request->status_santri,
            'allStatuses'  => $allStatuses,
        ]);
    }

    public function pdf(Request $request)
    {
        $search = $request->search;
        $statusFilter = $request->status_santri;

        $santris = Santri::when($search, function ($q) use ($search) {
            $q->where(function ($query) use ($search) {
                $query->where('nama', 'like', "%$search%")
                    ->orWhere('nis', 'like', "%$search%");
            });
        })
            ->when($statusFilter, function ($q) use ($statusFilter) {
                $q->where('status_santri', $statusFilter);
            })
            ->orderBy('nama')
            ->get();

        $tanggal = Carbon::now()->translatedFormat('d F Y');
        $judul = 'Laporan Status Santri'; // <-- tambahkan ini

        $pdf = Pdf::loadView('admin.status.pdf', compact(
            'santris',
            'search',
            'statusFilter',
            'tanggal',
            'judul' // <-- kirim ke view
        ))->setPaper('A4', 'portrait');

        return $pdf->download('laporan_status_santri.pdf');
    }
}
