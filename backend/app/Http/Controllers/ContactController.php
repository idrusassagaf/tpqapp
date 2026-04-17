<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // ✅ TAMPILKAN HALAMAN KONTAK (PUBLIC)
    public function index()
    {
        return view('public.kontak.kontak');
    }

    // ✅ SIMPAN PESAN (PUBLIC)
    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'subjek' => 'required',
            'pesan' => 'required',
        ]);

        // 🔥 FORMAT NOMOR (DI SINI POSISINYA)
        $no_hp = preg_replace('/^0/', '62', $request->no_hp);

        // SIMPAN
        Contact::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $no_hp, // 🔥 PAKAI YANG SUDAH DI FORMAT
            'subjek' => $request->subjek,
            'pesan' => $request->pesan,
        ]);

        return back()->with('success', 'Pesan berhasil dikirim!');
    }

    // ✅ ADMIN - LIST PESAN
    public function adminIndex()
    {
        $contacts = Contact::latest()->get();
        return view('admin.kontak.index', compact('contacts'));
    }

    // ✅ TANDAI DIBACA
    public function markAsRead($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update(['is_read' => true]);

        return back();
    }

    // ✅ HAPUS PESAN
    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return back()->with('success', 'Pesan dihapus!');
    }

    // ✅ BALAS PESAN (EMAIL)
    public function reply(Request $request, $id)
    {
        $request->validate([
            'balasan' => 'required'
        ]);

        $contact = Contact::findOrFail($id);

        Mail::raw($request->balasan, function ($message) use ($contact) {
            $message->to($contact->email)
                ->subject('Balasan: ' . $contact->subjek);
        });

        return back()->with('success', 'Balasan berhasil dikirim!');
    }
}
