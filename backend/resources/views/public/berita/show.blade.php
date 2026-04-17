@php use Illuminate\Support\Facades\DB; @endphp
@extends('public.layouts.app')

@section('content')

<div class="max-w-5xl mx-auto text-white font-extralight">

    <!-- CARD 
    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 shadow-xl"> 
        TIDAK DITAMPILKAN //-->

    <!-- JUDUL -->
    <h1 class="text-3xl md:text-4xl font-light mb-1 leading-tight">
        {{ $berita->judul }}
    </h1>

    <!-- TANGGAL -->
    <p class="text-sm text-white/70 mb-3">
        Ternate {{ $berita->created_at->format('d M Y') }}
    </p>

    <!-- FOTO + NARASI -->
    <div class="text-white/90 leading-relaxed text-justify">

        @if($berita->gambar)
        <img src="{{ asset('storage/' . $berita->gambar) }}"
            class="w-full md:w-80 float-left mr-5 mb-3 shadow-lg">
        @endif

        {!! nl2br(e($berita->isi)) !!}

        <div class="clear-both"></div>

        <div class="mt-6 flex items-center justify-between flex-wrap gap-3">

            <!-- KIRI: KEMBALI -->
            <a href="{{ route('berita.public.index') }}"
                class="text-white font-bold hover:underline text-sm">
                ← Kembali ke Daftar Berita
            </a>

            <!-- KANAN: LIKE -->
            <div class="flex items-center gap-3">

                <button id="btnLike"
                    class="px-2 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 active:scale-110 transition flex items-center gap-1">
                    👍 <span>Like</span>
                </button>

                <span id="likeCount" class="text-white/80 text-sm">
                    {{ $berita->likes }} Likes
                </span>

            </div>

        </div>


        {{-- ALERT --}}
        @if(session('success'))
        <div class="bg-green-500/20 text-green-300 p-2 rounded mb-4 mt-6">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-500/20 text-red-300 p-2 rounded mb-4 mt-6">
            {{ session('error') }}
        </div>
        @endif

        <!-- FORM KOMENTAR PUBLIK -->
        <div class="mt-10">
            <h3 class="text-sm font-bold mb-3">💬 Komentar</h3>

            <form action="{{ route('berita.komentar', $berita->id) }}" method="POST" class="space-y-3">
                @csrf

                <input type="text" name="nama" placeholder="Nama"
                    class="w-full p-2 rounded text-black">

                <textarea name="isi" placeholder="Tulis komentar..."
                    class="w-full p-2 rounded text-black"></textarea>

                <button class="bg-blue-500 px-4 py-2 rounded text-white">
                    Kirim
                </button>
            </form>
        </div>

        <!-- LIST KOMENTAR -->
        @php
        $komentars = DB::table('komentars')
        ->where('berita_id', $berita->id)
        ->latest()
        ->get();
        @endphp

        <div class="mt-6 space-y-4">

            @foreach($komentars->whereNull('parent_id') as $k)
            <div class="bg-white/10 p-3 rounded">

                <p class="font-semibold">{{ $k->nama }}</p>
                <p class="text-sm text-white/80 mt-1">{{ $k->isi }}</p>

                <!-- AKSI -->
                <div class="flex items-center gap-3 mt-2 text-xs">

                    <!-- BALAS -->
                    @if(auth()->check() && in_array(auth()->user()->role, ['super_admin','admin','admin_berita']))
                    <button onclick="reply('{{ $k->id }}')"
                        class="text-blue-300 hover:underline">
                        Balas
                    </button>
                    @endif

                    <!-- HAPUS -->
                    @if(auth()->check() && in_array(auth()->user()->role, ['super_admin','admin','admin_berita']))
                    <form action="{{ route('komentar.hapus', $k->id) }}" method="POST"
                        onsubmit="return confirm('Yakin hapus komentar ini?')">
                        @csrf
                        @method('DELETE')

                        <button class="text-red-400 hover:underline">
                            Hapus
                        </button>
                    </form>
                    @endif

                </div>

                <!-- FORM BALAS (WA STYLE) -->
                @if(auth()->check() && in_array(auth()->user()->role, ['super_admin','admin','admin_berita']))
                <form action="{{ route('berita.komentar', $berita->id) }}" method="POST"
                    id="reply-form-{{ $k->id }}" class="hidden mt-2">
                    @csrf

                    <input type="hidden" name="parent_id" value="{{ $k->id }}">

                    <!-- NAMA AUTO -->
                    <input type="text" name="nama"
                        value="{{ auth()->user()->name }}"
                        readonly
                        class="w-full p-1 rounded text-black text-sm mb-1 bg-gray-200">

                    <!-- ISI -->
                    <textarea name="isi" placeholder="Tulis balasan..."
                        class="w-full p-2 rounded text-black text-sm"></textarea>

                    <button class="bg-blue-500 px-3 py-1 text-xs rounded mt-1 text-white">
                        Kirim
                    </button>
                </form>
                @endif

                <!-- BALASAN (NEMPEL SEPERTI WA) -->
                <div class="mt-3 border-l border-white/20 pl-3 space-y-2">
                    @foreach($komentars->where('parent_id', $k->id) as $reply)
                    <div class="text-sm">

                        <p class="text-xs font-semibold text-blue-300">
                            {{ $reply->nama }}
                        </p>

                        <p class="text-xs text-white/70">
                            {{ $reply->isi }}
                        </p>

                    </div>
                    @endforeach
                </div>

            </div>
            @endforeach

        </div>
    </div>
</div>

<!-- SCRIPT -->
<script>
    function reply(id) {
        document.getElementById('reply-form-' + id).classList.toggle('hidden');
    }
</script>

<script>
    function reply(id) {
        document.getElementById('reply-form-' + id).classList.toggle('hidden');
    }

    // 🔥 LIKE AJAX
    document.getElementById('btnLike').addEventListener('click', function() {

        fetch("{{ route('berita.like', $berita->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('likeCount').innerText = data.likes + " Likes";
                }
            });

    });
</script>

@endsection