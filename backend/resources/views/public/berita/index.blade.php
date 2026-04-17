@extends('public.layouts.app')

@section('content')

<h2 class="text-3xl font-extralight text-left text-white mb-10">Berita TPQ Khairunissa</h2>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

    <!-- 🔵 KIRI (LIST BERITA) -->
    <div class="lg:col-span-3">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            @forelse($beritas as $berita)

            <div class="bg-white/10 backdrop-blur-md rounded-2xl overflow-hidden shadow-lg">

                <a href="{{ route('berita.public.show', $berita->slug) }}" class="block">

                    @if($berita->gambar)
                    <img src="{{ asset('storage/' . $berita->gambar) }}"
                        class="w-full h-48 object-cover">
                    @endif

                    <div class="p-4 bg-slate-900/30">

                        <!-- JUDUL -->
                        <h3 class="text-lg font-semibold text-white mb-2 leading-snug drop-shadow flex items-center gap-2 flex-wrap">
                            {{ $berita->judul }}

                            @if($berita->created_at >= now()->subDays(3))
                            <!-- 🟢 BARU -->
                            <span class="bg-emerald-400/20 text-emerald-300 text-[10px] px-2 py-1 rounded-full border border-emerald-400/30">
                                Baru
                            </span>

                            @elseif($berita->created_at >= now()->subDays(7))
                            <!-- 🟡 UPDATE -->
                            <span class="bg-yellow-400/20 text-yellow-300 text-[10px] px-2 py-1 rounded-full border border-yellow-400/30">
                                Update
                            </span>
                            @endif

                        </h3>

                        <!-- META -->
                        <div class="text-sm  text-white/70 flex flex-wrap items-center gap-2">

                            <span>{{ $berita->created_at->format('d M Y') }}</span>

                            <span>|</span>

                            <span>👁️ {{ number_format($berita->views ?? 0) }} Dilihat</span>

                            <span>|</span>

                            <span class="flex items-center gap-1 text-blue-300">
                                👍 <span class="font-semibold">{{ number_format($berita->likes ?? 0) }}</span>
                            </span>

                            <span>|</span>

                            <span class="hover:underline">
                                Baca Selengkapnya
                            </span>

                        </div>

                    </div>

                </a>

            </div>

            @empty
            <p class="text-white col-span-2 text-center">Belum ada berita.</p>
            @endforelse

        </div>

    </div>


    <!-- 🔥 KANAN (SIDEBAR POPULER) -->
    <div class="lg:col-span-1">

        <!-- TRENDING HARI INI -->
        <div class="mt-0 mb-4">
            <h3 class="text-xl text-emerald-400 font-semibold mb-4">
                ⚡ Trending Hari Ini
            </h3>

            <div class="space-y-2">
                @forelse($trending as $item)
                <div class="bg-white/10 p-3 rounded-lg flex justify-between items-center hover:bg-white/20 transition">

                    <a href="{{ route('berita.public.show', $item->slug) }}"
                        class="text-white font-extralight hover:underline text-sm">
                        {{ $item->judul }}
                    </a>

                    <span class="text-xs text-white/60">
                        👁️ {{ number_format($item->views_today ?? 0) }}
                    </span>

                </div>
                @empty
                <p class="text-white/60 text-sm">Belum ada trending hari ini</p>
                @endforelse
            </div>
        </div>
        <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl sticky top-6">
            <h3 class="text-lg text-emerald-400 font-semibold mb-4">
                🔥 Berita Terpopuler
            </h3>

            <div class="space-y-3">
                @foreach($populer as $item)
                <div class="flex justify-between items-center border-b border-white/10 pb-2">

                    <a href="{{ route('berita.public.show', $item->slug) }}"
                        class="text-white font-extralight text-sm hover:underline">
                        {{ $item->judul }}
                    </a>

                    <span class="text-xs text-white/60">
                        👁️ {{ number_format($item->views ?? 0) }}
                    </span>

                </div>
                @endforeach
            </div>

        </div>

    </div>

</div>

@endsection