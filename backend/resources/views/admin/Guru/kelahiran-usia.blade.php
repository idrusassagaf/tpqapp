@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between gap-4 mb-3">
        <div>
            <h1 class="text-2xl font-extralight tracking-wide text-slate-800">
                Data Kelahiran dan Usia Guru
            </h1>
            <p class="text-xs text-slate-500 font-light mt-1">
                Update tanggal lahir guru untuk menghitung usia otomatis.
            </p>
        </div>

        {{-- INFO KANAN ATAS --}}
        <div class="text-right space-y-2">

            <div class="text-sm text-slate-600 font-extralight tracking-wide">
                Total Guru:
                <span class="font-medium text-slate-800">{{ $gurus->count() }}</span>
            </div>

        </div>
    </div>
</div>

{{-- FLASH --}}
@if(session('success'))
<div class="mb-3 px-3 py-2 bg-green-100 text-green-700 rounded text-sm">
    {{ session('success') }}
</div>
@endif

{{-- TABLE CARD --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

    {{-- FILTER + SEARCH --}}
    <form id="filterForm" method="GET" action="{{ route('guru-kelahiran-usia.index') }}"
        class="px-3 py-2 border-b border-slate-200 bg-gray-100">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

            {{-- SEARCH --}}
            <input type="text"
                id="searchInput"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="Cari Nama / NIG"
                class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                    focus:outline-none focus:ring-2 focus:ring-sky-200" />

            {{-- FILTER GENDER --}}
            <select name="gender" id="genderSelect"
                class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                    focus:outline-none focus:ring-2 focus:ring-sky-200">
                <option value="">Semua Gender</option>
                <option value="L" {{ ($gender ?? '')=='L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ ($gender ?? '')=='P' ? 'selected' : '' }}>Perempuan</option>
            </select>

            {{-- RESET --}}
            <a href="{{ route('guru-kelahiran-usia.index') }}"
                class="w-full rounded-xl border border-slate-200 bg-white text-slate-700 px-4 py-2 text-sm font-extralight hover:bg-slate-50 transition text-center">
                Reset
            </a>

            <a href="{{ route('guru-kelahiran-usia.export.pdf') }}"
                class="w-full rounded-xl border border-slate-200 bg-white text-slate-700 px-4 py-2 text-sm font-extralight
                   hover:bg-slate-300 transition text-center">
                Download Kelahiran & Usia
            </a>

        </div>
    </form>

    {{-- TABLE --}}
    <div class="overflow-x-auto w-full">
        <table class="min-w-full text-xs table-fixed">
            <thead class="bg-slate-200 text-slate-600">
                <tr class="text-left">
                    <th class="px-2 py-1 w-[220px]">Nama Guru</th>
                    <th class="px-2 py-1 w-[70px] text-center">JK</th>
                    <th class="px-2 py-1 w-[200px] text-center">Kelahiran</th>
                    <th class="px-2 py-1 w-[90px] text-center">Usia</th>
                    @if(auth()->user()->isAdmin())
                    <th class="px-2 py-1 w-[160px] text-center">Aksi</th>
                    @endif
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 text-xs">
                @forelse ($gurus as $g)
                <tr class="hover:bg-slate-50/60 transition"
                    x-data="{ editing:false, tgl:'{{ $g->tgl_lahir }}' }">

                    {{-- NAMA --}}
                    <td class="px-2 py-1">
                        <div class="font-light text-slate-800">{{ $g->nama }}</div>
                        <div class="text-[10px] text-slate-500 font-extralight mt-0.5">
                            NIG: <span class="text-slate-700">{{ $g->nig }}</span>
                        </div>
                    </td>

                    {{-- JK --}}
                    <td class="px-3 py-2 text-center">
                        @if($g->jenis_kelamin)
                        <span class="inline-flex items-center justify-center w-8 py-0.5 rounded border border-slate-400 bg-white text-slate-700 text-xs font-medium">
                            {{ $g->jenis_kelamin }}
                        </span>
                        @else
                        <span class="text-slate-400 text-xs italic">-</span>
                        @endif
                    </td>


                    {{-- TANGGAL LAHIR --}}
                    <td class="px-2 py-1 text-center">

                        {{-- MODE VIEW --}}
                        <div x-show="!editing" class="leading-tight text-center">

                            {{-- TEMPAT LAHIR --}}
                            <div class="text-slate-800 font-light">
                                {{ $g->tempat_lahir ?? '-' }}
                            </div>

                            {{-- TANGGAL LAHIR --}}
                            <div class="text-xs text-slate-500">
                                @if ($g->tgl_lahir)
                                {{ \Carbon\Carbon::parse($g->tgl_lahir)->format('d-m-Y') }}
                                @else
                                <span class="italic">Belum diisi</span>
                                @endif
                            </div>

                        </div>

                        {{-- MODE EDIT --}}
                        <div x-show="editing" class="flex flex-col items-center gap-1">

                            <form method="POST"
                                action="{{ route('guru-kelahiran-usia.update', $g->id) }}"
                                class="flex flex-col items-center gap-1">
                                @csrf
                                @method('PUT')

                                {{-- TEMPAT LAHIR --}}
                                <input type="text"
                                    name="tempat_lahir"
                                    value="{{ $g->tempat_lahir }}"
                                    placeholder="Tempat lahir"
                                    class="w-[160px] rounded-xl border border-slate-300 px-3 py-1 text-xs bg-white
                focus:outline-none focus:ring-1 focus:ring-sky-200 text-center">

                                {{-- TANGGAL LAHIR --}}
                                <input type="date"
                                    name="tgl_lahir"
                                    x-model="tgl"
                                    class="w-[160px] rounded-xl border border-slate-300 px-3 py-1 text-xs bg-white
                focus:outline-none focus:ring-1 focus:ring-sky-200">

                                <button type="submit"
                                    class="inline-flex items-center justify-center px-2 py-1 rounded-xl
                bg-slate-900 text-white text-xs hover:bg-slate-800 transition"
                                    @click="editing=false">
                                    Simpan
                                </button>

                            </form>

                        </div>

                    </td>

                    {{-- USIA --}}
                    <td class="px-2 py-1 text-center text-slate-700">
                        @if ($g->tgl_lahir)
                        {{ \Carbon\Carbon::parse($g->tgl_lahir)->age }} th
                        @else
                        <span class="text-slate-400 italic font-extralight">-</span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    @if(auth()->user()->isAdmin())
                    <td class="px-2 py-1 text-center">
                        <div class="flex justify-center gap-1">

                            <button type="button"
                                x-show="!editing"
                                @click="editing=true"
                                class="inline-flex items-center justify-center px-2 py-0.5 rounded-xl
                bg-slate-400 text-white text-xs font-extralight hover:bg-slate-800 transition shadow-sm">
                                Edit
                            </button>

                            <form method="POST" action="{{ route('guru-kelahiran-usia.destroy', $g->id) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="inline-flex items-center justify-center px-2 py-0.5 rounded-xl
                    bg-slate-800 text-white text-xs font-extralight hover:bg-slate-700 transition shadow-sm"
                                    onclick="return confirm('Reset tanggal lahir guru ini?')">
                                    Reset
                                </button>
                            </form>

                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    @if(auth()->user()->isAdmin())
                    <td colspan="5" class="px-2 py-6 text-center text-slate-500 font-extralight">
                        @else
                    <td colspan="4" class="px-2 py-6 text-center text-slate-500 font-extralight">
                        @endif
                        Data tidak ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
</div>

{{-- Alpine --}}
<script src="//unpkg.com/alpinejs" defer></script>

{{-- SCRIPT FILTER --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const filterForm = document.getElementById('filterForm');
        const searchInput = document.getElementById('searchInput');
        const genderSelect = document.getElementById('genderSelect');

        let typingTimer;

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => {
                    filterForm.submit();
                }, 400);
            });
        }

        if (genderSelect) {
            genderSelect.addEventListener('change', function() {
                filterForm.submit();
            });
        }

    });
</script>
@endsection