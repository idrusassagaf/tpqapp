<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::query();

        if ($request->filled('q')) {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }

        $beritas = $query->latest()->paginate(10)->withQueryString();

        return view('admin.informasi.berita.index', compact('beritas'));
    }

    public function create()
    {
        return view('admin.informasi.berita.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:200',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:Draft,Publish',
        ]);

        $data['slug'] = Str::slug($data['judul']) . '-' . time();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create($data);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $beritum)
    {
        // Laravel auto naming: berita/{beritum}/edit
        return view('admin.informasi.berita.edit', [
            'berita' => $beritum
        ]);
    }

    public function update(Request $request, Berita $beritum)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:200',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:Draft,Publish',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $beritum->update($data);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $beritum)
    {
        $beritum->delete();
        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
    }
    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)
            ->where('status', 'Publish')
            ->firstOrFail();

        // Tambah views total
        $berita->views = $berita->views + 1;

        // Tambah views hari ini (PASTIKAN kolom sudah ada)
        $berita->views_today = ($berita->views_today ?? 0) + 1;

        $berita->save();

        return view('public.berita.show', compact('berita'));
    }
    public function publicIndex()

    {
        // 📰 LIST UTAMA
        $beritas = Berita::where('status', 'Publish')
            ->latest()
            ->take(6)
            ->get();

        // 🔥 POPULER
        $populer = Berita::where('status', 'Publish')
            ->orderBy('views', 'desc')
            ->get();

        // ⚡ TRENDING (INI YANG KEMARIN KURANG)
        $trending = Berita::where('status', 'Publish')
            ->orderBy('views_today', 'desc')
            ->take(3)
            ->get();

        return view('public.berita.index', compact('beritas', 'populer', 'trending'));
    }

    public function like($id)
    {
        $berita = Berita::findOrFail($id);

        $berita->increment('likes'); // lebih clean & aman

        return response()->json([
            'success' => true,
            'likes' => $berita->likes
        ]);
    }

    public function komentar(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'isi' => 'required'
        ]);

        $badWords = ['anjing', 'bodoh', 'jelek', 'kafir', 'goblok', 'babi', 'bangsat', 'kontol', 'memek', 'perek', 'titit', 'jembut', 'bajingan', 'bacot', 'brengsek', 'kampret', 'tai', 'tolol'];

        foreach ($badWords as $word) {
            if (stripos($request->isi, $word) !== false) {
                return back()->with('error', 'Komentar mengandung kata tidak pantas');
            }
        }

        DB::table('komentars')->insert([
            'berita_id' => $id,
            'nama' => $request->nama,
            'isi' => $request->isi,
            'parent_id' => $request->parent_id ?? null, // 🔥 INI PENTING
            'created_at' => now()
        ]);

        return back();
    }
    public function hapusKomentar($id)
    {
        DB::table('komentars')->where('id', $id)->delete();

        return back()->with('success', 'Komentar berhasil dihapus');
    }
}
