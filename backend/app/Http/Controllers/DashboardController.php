<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Guru;
use App\Models\Orangtua;
use App\Models\Berita;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSantri = Santri::count();
        $totalGuru = Guru::count();
        $totalOrangtua = Orangtua::count();
        $totalBerita = Berita::count();

        $santriTerbaru = Santri::with('orangtua')
            ->latest()
            ->take(5)
            ->get();

        $genderL = Santri::where('jk', 'L')->count();
        $genderP = Santri::where('jk', 'P')->count();

        $kelasData = Santri::selectRaw('kelas, COUNT(*) as total')
            ->whereNotNull('kelas')
            ->where('kelas', '!=', '')
            ->groupBy('kelas')
            ->orderBy('kelas', 'asc')
            ->get();

        $kelasLabels = $kelasData->pluck('kelas');
        $kelasTotals = $kelasData->pluck('total');

        return view('admin.dashboard', compact(
            'totalSantri',
            'totalGuru',
            'totalOrangtua',
            'totalBerita',
            'santriTerbaru',
            'genderL',
            'genderP',
            'kelasLabels',
            'kelasTotals'
        ));
    }
}
