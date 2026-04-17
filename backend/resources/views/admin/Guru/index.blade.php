@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between gap-4 mb-3">
        <div>
            <h1 class="text-2xl font-extralight tracking-wide text-slate-800">
                Data Guru
            </h1>
            <p class="text-xs text-slate-800 font-light mt-1">
                Kelola data guru versi Tabel dan Card lengkap dengan foto, mapel, dan jenis kelamin.
            </p>
        </div>

        {{-- INFO KANAN ATAS --}}
        <div class="text-right">
            <div class="text-sm text-slate-600 font-extralight tracking-wide">
                Total Guru: <span class="font-medium text-slate-800">{{ $gurus->count() }}</span>
            </div>
        </div>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
    <div class="mb-3 px-3 py-2 bg-green-100 text-green-700 rounded text-sm">
        {{ session('success') }}
    </div>
    @endif

    {{-- FILTER + SEARCH --}}
    <form id="filterForm" method="GET" action="{{ route('guru.index') }}"
        class="px-3 py-2 border-b border-slate-200 bg-gray-100 rounded-2xl border mb-4">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-2">

            {{-- SEARCH NAMA --}}
            <input type="text"
                id="searchInput"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="Nama Guru"
                class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                focus:outline-none focus:ring-2 focus:ring-sky-200" />

            {{-- FILTER MAPEL --}}
            <select name="mapel" id="mapelSelect"
                class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                focus:outline-none focus:ring-2 focus:ring-sky-200">
                <option value="">Semua Mapel</option>
                @foreach($mapelList as $mapel)
                <option value="{{ $mapel }}" {{ ($mapelFilter ?? '') == $mapel ? 'selected' : '' }}>
                    {{ $mapel }}
                </option>
                @endforeach
            </select>

            {{-- RESET --}}
            <a href="{{ route('guru.index') }}"
                class="w-full rounded-xl border border-slate-200 bg-white text-slate-700 px-4 py-2 text-sm font-extralight hover:bg-slate-50 text-center transition">
                Reset
            </a>
            <a href="{{ route('guru.export.pdf') }}"
                class="w-full rounded-xl border border-slate-200 bg-white text-slate-700 px-4 py-2 text-sm font-extralight
                   hover:bg-slate-300 transition text-center">
                Download Data Guru
            </a>
        </div>
    </form>

    {{-- Tombol Switch Table / Card + PDF --}}
    {{-- SWITCH VIEW (IDENTIK SANTRI) --}}
    <div class="flex items-center gap-2 mb-3">

        <div class="inline-flex rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm">

            <button id="btnTable" type="button"
                class="px-3 py-1 text-xs font-extralight transition
                   bg-slate-400 text-white">
                Tabel
            </button>

            <button id="btnCard" type="button"
                class="px-3 py-1 text-xs font-extralight transition
                   bg-white text-slate-900 border-l border-slate-200 hover:bg-slate-50">
                Card
            </button>

        </div>

    </div>

    {{-- TABLE VIEW --}}
    <div id="tableView" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-x-auto">
        <table class="min-w-full text-xs table-fixed">
            <thead class="bg-slate-200 text-slate-600">
                <tr class="text-left">
                    <th class="px-2 py-1 w-[40px]">No</th>
                    <th class="px-2 py-1 w-[220px]">Nama Guru</th>
                    <th class="px-2 py-1 w-[120px] text-center">NIG</th>
                    <th class="px-2 py-1 w-[90px] text-center">JK</th>
                    <th class="px-2 py-1 w-[140px] text-center">Mapel</th>
                    @if(auth()->user()->isAdmin())
                    <th class="px-2 py-1 w-[120px] text-center">Aksi</th>
                    @endif
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse($gurus as $i => $g)
                <tr class="hover:bg-slate-50/60 transition">

                    <td class="px-2 py-1 text-slate-500 font-extralight">
                        {{ $i + 1 }}
                    </td>

                    <td class="px-2 py-1">
                        <div class="font-light text-slate-800">{{ $g->nama }}</div>
                        <div class="text-[10px] text-slate-500 font-extralight mt-0.5">
                            Mapel: <span class="text-slate-700">{{ $g->mapel ?? '-' }}</span>
                        </div>
                    </td>

                    <td class="px-2 py-1 text-center text-slate-700">
                        {{ $g->nig }}
                    </td>

                    <td class="px-3 py-2 text-center">
                        @if($g->jenis_kelamin)
                        <span class="inline-flex items-center justify-center w-8 py-0.5 rounded border border-slate-400 bg-white text-slate-700 text-xs font-medium">
                            {{ $g->jenis_kelamin }}
                        </span>
                        @else
                        <span class="text-slate-400 text-xs italic">-</span>
                        @endif
                    </td>


                    <td class="px-2 py-1 text-center text-slate-700">
                        {{ $g->mapel }}
                    </td>

                    @if(auth()->user()->isAdmin())
                    <td class="px-2 py-1 text-center space-x-1">

                        <a href="{{ route('guru.edit',$g->id) }}"
                            class="inline-flex items-center justify-center px-1 py-0.5 rounded-xl
        bg-slate-400 text-white text-xs font-extralight hover:bg-slate-800 transition shadow-sm">
                            Edit
                        </a>
                        <form action="{{ route('guru.destroy',$g->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center justify-center px-1 py-0.5 rounded-xl
                                bg-slate-800 text-white text-xs font-extralight hover:bg-slate-400 transition shadow-sm"
                                onclick="return confirm('Hapus?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>

                @empty
                <tr>
                    @if(auth()->user()->isAdmin())
                    <td colspan="6" class="px-2 py-6 text-center text-slate-500 font-extralight">
                        @else
                    <td colspan="5" class="px-2 py-6 text-center text-slate-500 font-extralight">
                        @endif
                        Data guru belum tersedia.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- CARD VIEW MODERN --}}
    <div id="cardView" class="hidden grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

        @foreach($gurus as $g)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 flex flex-col items-center text-center
            transition-transform transform hover:scale-[1.02] hover:shadow-md">

            <div class="relative">
                <img src="{{ $g->foto && file_exists(storage_path('app/public/'.$g->foto)) ? asset('storage/'.$g->foto) : asset('images/default.png') }}"
                    alt="Foto Guru"
                    class="w-28 h-28 rounded-full object-cover border border-slate-200 shadow-sm">
            </div>

            <h2 class="font-light text-base mt-3 text-slate-800">
                {{ $g->nama }}
            </h2>

            <p class="text-xs text-slate-500 mt-1">
                NIG: <span class="text-slate-700">{{ $g->nig ?? '-' }}</span>
            </p>

            <p class="text-xs text-slate-500 mt-1">
                JK: <span class="text-slate-700">{{ $g->jenis_kelamin ?? '-' }}</span>
                | Mapel: <span class="text-slate-700">{{ $g->mapel ?? '-' }}</span>
            </p>
            @if(auth()->user()->isAdmin())
            <div class="mt-4 flex gap-2">

                <a href="{{ route('guru.edit', $g->id) }}"
                    class="inline-flex items-center justify-center px-3 py-1 rounded-xl
    bg-slate-400 text-white text-xs font-extralight hover:bg-slate-800 transition shadow-sm">
                    Edit
                </a>

                <form action="{{ route('guru.destroy',$g->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="inline-flex items-center justify-center px-3 py-1 rounded-xl
        bg-slate-800 text-white text-xs font-extralight hover:bg-slate-700 transition shadow-sm"
                        onclick="return confirm('Hapus?')">
                        Hapus
                    </button>
                </form>
            </div>
            @endif

        </div>
        @endforeach

    </div>

</div>

{{-- SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ==========================
        // FILTER SEARCH (LIVE)
        // ==========================
        const filterForm = document.getElementById('filterForm');
        const searchInput = document.getElementById('searchInput');
        const mapelSelect = document.getElementById('mapelSelect');

        let typingTimer;

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => {
                    filterForm.submit();
                }, 400);
            });
        }

        if (mapelSelect) {
            mapelSelect.addEventListener('change', function() {
                filterForm.submit();
            });
        }

        // ==========================
        // SWITCH TABLE / CARD + ACTIVE BUTTON
        // ==========================
        // ==========================
        // SWITCH TABLE / CARD
        // ==========================
        const btnTable = document.getElementById('btnTable');
        const btnCard = document.getElementById('btnCard');
        const tableView = document.getElementById('tableView');
        const cardView = document.getElementById('cardView');

        btnTable.onclick = () => {
            tableView.classList.remove('hidden');
            cardView.classList.add('hidden');

            btnTable.className =
                "px-3 py-1 text-xs font-extralight transition bg-slate-400 text-white";

            btnCard.className =
                "px-3 py-1 text-xs font-extralight transition bg-white text-slate-900 border-l border-slate-200 hover:bg-slate-50";
        };

        btnCard.onclick = () => {
            cardView.classList.remove('hidden');
            tableView.classList.add('hidden');

            btnCard.className =
                "px-3 py-1 text-xs font-extralight transition bg-slate-400 text-white";

            btnTable.className =
                "px-3 py-1 text-xs font-extralight transition bg-white text-slate-900 border-l border-slate-200 hover:bg-slate-50";
        };
    });
</script>
@endsection