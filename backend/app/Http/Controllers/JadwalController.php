<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;

class JadwalController extends Controller
{
    // Menampilkan halaman kalender
    public function index()
    {
        return view('admin.informasi.jadwal.index');
    }

    // Endpoint JSON untuk FullCalendar
    public function getJadwal()
    {
        $jadwals = Jadwal::orderBy('tanggal', 'asc')->get();

        $events = $jadwals->map(function ($j) {
            return [
                'title'  => ucfirst($j->status),
                'start'  => $j->tanggal,
                'allDay' => true,
                'color'  => $j->status === 'mengaji' ? '#16a34a' : '#dc2626', // Hijau/Merah otomatis
            ];
        });

        return response()->json($events);
    }

    // Update atau buat jadwal
    public function updateJadwal(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'status'  => 'required|in:mengaji,libur',
        ]);

        $jadwal = Jadwal::updateOrCreate(
            ['tanggal' => $request->tanggal],
            ['status' => $request->status]
        );

        return response()->json(['success' => true]);
    }

    public function indexPublic(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $jadwals = Jadwal::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        return view('public.jadwal.index', compact('jadwals', 'bulan', 'tahun'));
    }
}
