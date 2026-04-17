@extends('public.layouts.app')

@section('content')

<!-- HEADER -->
<div class="max-w-6xl mx-auto px-4 py-8 text-center md:text-left">
    <h1 class="text-xl md:text-2xl font-semibold mb-2">
        Pengumuman
    </h1>
    <p class="text-blue-100 text-sm">
        Informasi terbaru dari TPQ Khairunissa
    </p>
</div>

<!-- LIST PENGUMUMAN -->
<div class="max-w-6xl mx-auto px-4 pb-16 grid gap-6 md:grid-cols-2">

    @forelse($pengumumans as $item)

    <div class="bg-white/10 backdrop-blur-md rounded-xl p-5 shadow transition hover:shadow-lg h-full flex flex-col justify-between">

        <div>

            <!-- TANGGAL -->
            <div class="text-xs text-blue-200 mb-2">
                {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
            </div>

            <!-- JUDUL -->
            <h2 class="text-lg font-semibold mb-2">
                {{ $item->judul }}
            </h2>

            <!-- ISI -->
            <p class="text-sm text-blue-100 font-extralight line-clamp-3 text-justify">
                {{ $item->isi }}
            </p>

        </div>

        <!-- LINK -->
        <a href="{{ route('pengumuman.public.show', $item->id) }}"
            class="mt-3 text-blue-200 hover:text-white text-xs font-medium transition">
            Baca Selengkapnya →
        </a>

    </div>
    @empty

    <div class="col-span-full text-center text-blue-200">
        Belum ada pengumuman
    </div>

    @endforelse

</div>

</div>

@endsection