@extends('public.layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10">

    <!-- CARD -->
    <div class="bg-white text-slate-800 p-8 rounded-2xl shadow-xl">

        <h2 class="text-2xl font-bold mb-6 text-center">
            📩 Kontak Kami
        </h2>

        @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('kontak.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Nama -->
            <div>
                <label class="block mb-1 text-sm font-semibold">Nama</label>
                <input type="text" name="nama"
                    class="w-full border border-slate-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Email -->
            <div>
                <label class="block mb-1 text-sm font-semibold">Email</label>
                <input type="email" name="email"
                    class="w-full border border-slate-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- NO HP -->
            <div>
                <label class="text-sm font-medium">No HP / WhatsApp</label>
                <input type="text" name="no_hp" placeholder="Contoh: 08123456789"
                    class="w-full border p-2 rounded mt-1"
                    required>
            </div>

            <!-- Subjek -->
            <div>
                <label class="block mb-1 text-sm font-semibold">Subjek</label>
                <input type="text" name="subjek"
                    class="w-full border border-slate-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Pesan -->
            <div>
                <label class="block mb-1 text-sm font-semibold">Pesan</label>
                <textarea name="pesan" rows="4"
                    class="w-full border border-slate-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <!-- Button -->
            <button type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-blue-800 text-white py-3 rounded-lg font-semibold hover:opacity-90 transition">
                Kirim Pesan
            </button>
        </form>

    </div>

</div>
@endsection