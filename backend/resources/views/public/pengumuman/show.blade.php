@extends('public.layouts.app')

@section('content')

<!-- HERO -->
<div class="max-w-4xl mx-auto px-6 pt-2 pb-2 text-center">

    <h1 class="text-3xl md:text-4xl font-semibold mb-4 leading-snug">
        {{ $pengumuman->judul }}
    </h1>

    <p class="text-blue-200 text-sm">
        📅 {{ $pengumuman->created_at->translatedFormat('d F Y') }}
    </p>

</div>

<!-- CONTENT -->
<div class="max-w-4xl mx-auto px-6 pb-20">

    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 md:p-8 shadow-lg">

        <!-- ISI -->
        <div class="text-blue-100 font-extralight leading-relaxed text-justify space-y-4">
            {!! nl2br(e($pengumuman->isi)) !!}
        </div>

        <!-- ACTION -->
        <div class="mt-8 flex flex-col md:flex-row gap-3 justify-between items-center">

            <!-- BACK -->
            <a href="/pengumuman"
                class="px-4 py-2 bg-white/20 rounded hover:bg-white/30 transition text-sm">
                ← Kembali
            </a>

            <!-- SHARE -->
            <a target="_blank"
                href="https://wa.me/?text={{ urlencode($pengumuman->judul . ' - ' . url()->current()) }}"
                class="px-4 py-2 bg-green-500 rounded hover:bg-green-600 text-sm">
                📤 Share WhatsApp
            </a>

        </div>

    </div>

</div>

</div>

@endsection