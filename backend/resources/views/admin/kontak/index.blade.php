@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-6">
    <h1 class="text-xl font-bold mb-4">📩 Pesan Masuk</h1>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white shadow rounded-xl overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-slate-100 text-left">
                <tr>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">No HP</th>
                    <th class="p-3">Subjek</th>
                    <th class="p-3">Pesan</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($contacts as $c)
                <tr class="border-b text-xs text-slate-900 {{ isset($c->is_read) && !$c->is_read ? 'bg-blue-50' : '' }}">

                    <td class="p-2">{{ $c->nama }}</td>
                    <td class="p-2">{{ $c->email }}</td>
                    <td class="p-2">{{ $c->no_hp }}</td>
                    <td class="p-2">{{ $c->subjek }}</td>
                    <td class="p-2">{{ $c->pesan }}</td>
                    <td class="p-2">{{ $c->created_at ? $c->created_at->format('d-m-Y') : '-' }}</td>
                    <!-- STATUS -->
                    <td class="p-2">
                        @if(isset($c->is_read) && $c->is_read)
                        <span class="text-green-600">Dibaca</span>
                        @else
                        <span class="text-red-500">Baru</span>
                        @endif
                    </td>

                    <!-- AKSI -->
                    <td class="p-2 space-y-1">

                        <!-- READ -->
                        @if(isset($c->is_read) && !$c->is_read)
                        <form action="{{ route('kontak.read', $c->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-blue-600 text-xs">✔ Baca</button>
                        </form>
                        @endif

                        <!-- DELETE -->
                        <form action="{{ route('kontak.delete', $c->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 text-xs">🗑 Hapus</button>
                        </form>

                        <!-- BALAS -->
                        <button type="button"
                            data-id="{{ $c->id }}"
                            onclick="toggleReply(this)"
                            class="text-green-600 text-xs">
                            ✉ Balas
                        </button>

                        <!-- WHATSAPP -->
                        <a href="https://wa.me/{{ $c->no_hp }}?text={{ urlencode('Assalamu\'alaikum '.$c->nama.', pesan Anda telah kami terima. Terima kasih 🙏') }}"
                            target="_blank"
                            class="text-green-600 text-xs">
                            💬 WA
                        </a>
                    </td>
                </tr>

                <!-- FORM BALAS -->
                <tr id="reply-{{ $c->id }}" style="display:none;">
                    <td colspan="8" class="p-3 bg-gray-50">

                        <form action="{{ route('kontak.reply', $c->id) }}" method="POST">
                            @csrf
                            <textarea name="balasan"
                                class="w-full border p-2 rounded mb-2 text-sm"
                                placeholder="Tulis balasan..."></textarea>
                            <button type="submit"
                                class="bg-green-600 text-white px-3 py-1 rounded text-sm">
                                Kirim Balasan
                            </button>

                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center p-4">Belum ada pesan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function toggleReply(btn) {
        const id = btn.getAttribute('data-id');
        const el = document.getElementById('reply-' + id);

        if (!el) return;

        if (el.style.display === 'none') {
            el.style.display = 'table-row';
        } else {
            el.style.display = 'none';
        }
    }
</script>

@endsection