<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Santri;
use App\Models\Guru;
use App\Models\Orangtua;
use App\Models\Berita;
use App\Models\Galeri;
use Carbon\Carbon;

class PublicController extends Controller
{
    public function home()
    {
        // Statistik
        $totalSantri = Santri::count();
        $totalGuru = Guru::count();
        $totalOrangtua = Orangtua::count();
        $totalBerita = Berita::count();

        // 🔥 Ambil data galeri (8 terbaru)
        $galeris = Galeri::latest()->take(8)->get();

        return view('public.home', compact(
            'totalSantri',
            'totalGuru',
            'totalOrangtua',
            'totalBerita',
            'galeris' // 🔥 WAJIB ditambahkan
        ));
    }
    public function dataSantri()
    {
        $total = Santri::count();

        $laki = Santri::where('jk', 'L')->count();
        $perempuan = Santri::where('jk', 'P')->count();

        $status = Santri::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $kelas = Santri::select('kelas', DB::raw('count(*) as total'))
            ->groupBy('kelas')
            ->get();

        // ======================
        // PROGRES IQRA
        // ======================
        $progresIqra = DB::table('progres_iqras')
            ->select(
                'iqra',
                DB::raw("SUM(CASE WHEN ulang_lanjut='Ulang' THEN 1 ELSE 0 END) as ulang"),
                DB::raw("SUM(CASE WHEN ulang_lanjut='Lanjut' THEN 1 ELSE 0 END) as lanjut")
            )
            ->groupBy('iqra')
            ->get()
            ->keyBy('iqra');
        // ======================
        // PROGRES AL QURAN
        // ======================
        $progresQuran = DB::table('progres_alqurans')
            ->select(
                DB::raw("SUM(CASE WHEN progres='Belum LCR' THEN 1 ELSE 0 END) as ulang"),
                DB::raw("SUM(CASE WHEN progres='Sudah LCR' THEN 1 ELSE 0 END) as lanjut")
            )
            ->first();

        // =====================
        // 🔥 TAMBAHAN CARD (9 DATA)
        // =====================

        // =====================
        // 🔥 STATUS DARI ORANGTUA (RELASI)
        // =====================

        $yatim = Santri::where('status_santri', 'Yatim')->count();
        $piatu = Santri::where('status_santri', 'Piatu')->count();
        $yatimPiatu = Santri::where('status_santri', 'Yatim Piatu')->count();

        // 🔥 SANTUNAN (KEDUANYA HIDUP)
        $santunan = Santri::where('status_santri', 'Santunan Orangtua')->count();

        // QURAN
        $quran = Santri::where('kelas', 'Al Quran')->count();

        // IQRA (LOGIKA FIX)
        $iqra = $total - $quran;

        // 🔥 TAMBAHAN TANGGAL
        $tanggal = Carbon::now()->format('d F Y');

        return view('public.santri.index', compact(
            'total',
            'laki',
            'perempuan',
            'status',
            'kelas',

            'quran',
            'iqra',
            'yatim',
            'piatu',
            'yatimPiatu',
            'santunan',
            'tanggal',

            'progresIqra',
            'progresQuran'
        ));
    }

    public function profil()
    {
        $path = storage_path('app/profil.json');

        if (file_exists($path)) {
            $profil = json_decode(file_get_contents($path), true);
        } else {
            $profil = [];
        }

        return view('public.profil.index', compact('profil'));
    }
}
