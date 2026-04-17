@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between gap-4 mb-3">
        <div>
            <h1 class="text-2xl font-extralight tracking-wide text-slate-800">
                Status Orang Tua
            </h1>
            <p class="text-sm text-slate-500 font-light mt-1">
                Status orang tua bisa diedit langsung. Data ayah dan ibu diambil dari relasi santri.
            </p>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div class="mb-4" id="flash-success">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
                bg-slate-300 border border-green-200 text-green-700
                text-sm font-extralight shadow-sm">
            <span class="text-green-600">✔</span>
            <span>{{ session('success') }}</span>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const flash = document.getElementById('flash-success');
            if (flash) flash.style.display = 'none';
        }, 3000);
    </script>
    @endif


    {{-- FILTER + SEARCH --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-4">

        <form id="filterForm" method="GET" action="{{ route('orangtua.index') }}"
            class="px-3 py-2 border-b border-slate-200 bg-gray-100">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">

                {{-- SEARCH --}}
                <div>
                    <label class="text-slate-600 text-xs font-extralight">Nama Ayah / Ibu</label>
                    <input type="text"
                        id="searchInput"
                        name="search"
                        value="{{ $search ?? '' }}"
                        placeholder="Cari nama..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                           focus:outline-none focus:ring-2 focus:ring-sky-200">
                </div>

                {{-- FILTER STATUS --}}
                <div>
                    <label class="text-slate-600 text-xs font-extralight">Status Orang Tua</label>
                    <select name="status"
                        onchange="this.form.submit()"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                            focus:outline-none focus:ring-2 focus:ring-sky-200">
                        <option value="">Semua</option>
                        <option value="Ayah Wafat" {{ ($statusFilter ?? '') == 'Ayah Wafat' ? 'selected' : '' }}>Ayah Wafat</option>
                        <option value="Ibu Wafat" {{ ($statusFilter ?? '') == 'Ibu Wafat' ? 'selected' : '' }}>Ibu Wafat</option>
                        <option value="Keduanya Hidup" {{ ($statusFilter ?? '') == 'Keduanya Hidup' ? 'selected' : '' }}>Keduanya Hidup</option>
                        <option value="Keduanya Wafat" {{ ($statusFilter ?? '') == 'Keduanya Wafat' ? 'selected' : '' }}>Keduanya Wafat</option>
                    </select>
                </div>

                {{-- RESET --}}
                <div>
                    <a href="{{ route('orangtua.index') }}"
                        class="block w-full rounded-xl border border-slate-200 bg-white text-slate-700
                       px-4 py-2 text-sm font-extralight hover:bg-slate-50 transition text-center">
                        Reset
                    </a>
                </div>

            </div>
        </form>

        {{-- TABLE --}}
        <div class="overflow-x-auto w-full">
            <table class="min-w-full text-xs table-fixed">
                <thead class="bg-slate-200 text-slate-600">
                    <tr class="text-left">
                        <th class="px-2 py-1 w-[110px] text-center font-normal">NIS</th>
                        <th class="px-2 py-1 font-normal">Nama Ayah</th>
                        <th class="px-2 py-1 font-normal">Nama Ibu</th>
                        <th class="px-2 py-1 w-[220px] font-normal">Status Orang Tua</th>
                        @if(auth()->user()->isAdmin())
                        <th class="px-2 py-1 w-[140px] text-center font-normal">Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse ($santris as $s)
                    <tr class="hover:bg-slate-50/60 transition">

                        {{-- NIS --}}
                        <td class="px-2 py-1 text-center text-slate-600">
                            {{ $s->nis ?? '-' }}
                        </td>

                        {{-- AYAH --}}
                        <td class="px-2 py-1 text-slate-800 font-light">
                            {{ $s->orangtua->nama_ayah ?? '-' }}
                        </td>

                        {{-- IBU --}}
                        <td class="px-2 py-1 text-slate-800 font-light">
                            {{ $s->orangtua->nama_ibu ?? '-' }}
                        </td>

                        {{-- STATUS --}}
                        <td class="px-2 py-1">
                            @if($s->orangtua)
                            <form action="{{ route('orangtua.update', $s->orangtua->id) }}"
                                method="POST"
                                class="inline-flex w-full items-center gap-2">
                                @csrf
                                @method('PATCH')

                                <select name="status_orangtua"
                                    class="w-full rounded-xl border border-slate-200 px-3 py-1 text-xs bg-slate-100
                                    focus:outline-none focus:ring-2 focus:ring-sky-200"
                                    {{ auth()->user()->isAdmin() ? '' : 'disabled' }}>
                                    <option value="Ayah Wafat" {{ $s->orangtua->status_orangtua == 'Ayah Wafat' ? 'selected' : '' }}>Ayah Wafat</option>
                                    <option value="Ibu Wafat" {{ $s->orangtua->status_orangtua == 'Ibu Wafat' ? 'selected' : '' }}>Ibu Wafat</option>
                                    <option value="Keduanya Hidup" {{ $s->orangtua->status_orangtua == 'Keduanya Hidup' ? 'selected' : '' }}>Keduanya Hidup</option>
                                    <option value="Keduanya Wafat" {{ $s->orangtua->status_orangtua == 'Keduanya Wafat' ? 'selected' : '' }}>Keduanya Wafat</option>
                                </select>
                        </td>

                        {{-- AKSI --}}
                        @if(auth()->user()->isAdmin())
                        <td class="px-2 py-1 text-center">
                            <div class="inline-flex gap-2 justify-center">

                                <button type="button"
                                    onclick="
                const tr = this.closest('tr');
                const select = tr.querySelector('select[name=status_orangtua]');
                select.disabled = false;

                this.style.display='none';
                this.nextElementSibling.style.display='inline-flex';
            "
                                    class="inline-flex items-center justify-center px-3 py-1 rounded-xl
            bg-slate-400 text-white text-xs font-extralight hover:bg-slate-800 transition shadow-sm">
                                    Edit
                                </button>

                                <button type="submit" style="display:none"
                                    class="inline-flex items-center justify-center px-3 py-1 rounded-xl
                                bg-slate-600 text-white text-xs font-extralight hover:bg-slate-700 transition shadow-sm">
                                    Simpan
                                </button>

                            </div>
                        </td>
                        @endif
                        </form>
                        @else
                        <span class="text-xs text-slate-400 italic">Belum direlasikan</span>
                        @endif

                    </tr>
                    @empty
                    <tr>
                        @if(auth()->user()->isAdmin())
                        <td colspan="5" class="px-2 py-6 text-center text-slate-500 font-extralight">
                            @else
                        <td colspan="4" class="px-2 py-6 text-center text-slate-500 font-extralight">
                            @endif
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

{{-- LIVE SEARCH --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('filterForm');
        const input = document.getElementById('searchInput');

        let timer;
        input.addEventListener('input', function() {
            clearTimeout(timer);
            timer = setTimeout(() => form.submit(), 350);
        });
    });
</script>
@endsection