@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between gap-4 mb-3">
        <div>
            <h1 class="text-2xl font-extralight tracking-wide text-slate-800">
                Status Keluarga Santri
            </h1>
            <p class="text-sm text-slate-500 font-light mt-1">
                Informasi status sosial tiap santri.
            </p>
        </div>

        {{-- INFO KANAN ATAS --}}
        <div class="text-right">
            <div class="text-sm text-slate-600 font-extralight tracking-wide">
                Total Santri: <span class="font-medium text-slate-800">{{ $santris->count() }}</span>
            </div>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        {{-- FILTER + SEARCH --}}
        <form id="filterForm" method="GET" action="{{ route('status.index') }}"
            class="px-3 py-2 border-b border-slate-200 bg-gray-100">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

                {{-- SEARCH NAMA --}}
                <input type="text"
                    name="search"
                    value="{{ $search ?? '' }}"
                    placeholder="Nama Santri"
                    class="js-filter w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                       focus:outline-none focus:ring-2 focus:ring-sky-200" />

                {{-- FILTER STATUS SOSIAL --}}
                <select name="status_santri"
                    class="js-filter w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                        focus:outline-none focus:ring-2 focus:ring-sky-200">
                    <option value="">Semua Status</option>
                    @foreach($allStatuses as $status)
                    <option value="{{ $status }}" {{ ($statusFilter ?? '') == $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                    @endforeach
                </select>

                {{-- RESET --}}
                <a href="{{ route('status.index') }}"
                    class="w-full h-[42px] flex items-center justify-center
           rounded-xl border border-slate-200 
           bg-white text-slate-700 
           px-4 text-sm font-extralight 
           hover:bg-slate-200 transition">
                    Reset
                </a>

                {{-- DOWNLOAD --}}
                <a href="{{ route('status.pdf', request()->query()) }}"
                    class="w-full h-[42px] flex items-center justify-center
           rounded-xl border border-slate-200 
           bg-white text-slate-700 
           px-4 text-sm font-extralight 
           hover:bg-slate-300 transition">
                    Download Data Status
                </a>
            </div>
        </form>

        {{-- TABLE --}}
        <div class="overflow-x-auto w-full">
            <table class="min-w-full text-xs table-fixed">
                <thead class="bg-slate-200 text-slate-600">
                    <tr class="text-left">
                        {{-- No dibuat sempit + agak ke kanan --}}
                        <th class="pl-6 pr-1 py-1 w-[40px]">No</th>

                        {{-- Nama dibuat lebih dekat ke No --}}
                        <th class="pl-2 pr-4 py-1 w-[280px]">Nama Santri</th>

                        <th class="px-4 py-1 w-[240px]">Status Sosial</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($santris as $i => $s)
                    <tr class="hover:bg-slate-50/60 transition">

                        {{-- NO --}}
                        <td class="pl-6 pr-1 py-1 text-slate-500 font-extralight">
                            {{ $i + 1 }}
                        </td>

                        {{-- NAMA --}}
                        <td class="pl-2 pr-4 py-1">
                            <div class="font-light text-slate-800">
                                {{ $s->nama }}
                            </div>
                            <div class="text-[10px] text-slate-500 font-extralight mt-0.5">
                                NIS: <span class="text-slate-700">{{ $s->nis ?? '-' }}</span>
                            </div>
                        </td>


                        {{-- STATUS SOSIAL --}}
                        <td class="px-4 py-1">
                            <div class="text-slate-800 font-light">
                                {{ $s->status_santri ?? '-' }}
                            </div>
                            <div class="text-[10px] text-slate-900 font-light mt-0.5">
                                Orang Tua: {{ $s->orangtua->nama_ayah ?? '-' }} & {{ $s->orangtua->nama_ibu ?? '-' }}
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-4 py-6 text-center text-slate-500 font-extralight">
                            Data santri belum tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
</div>

{{-- SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterForm = document.getElementById('filterForm');
        if (!filterForm) return;

        let typingTimer;

        const submitFilter = () => filterForm.submit();

        // LIVE SEARCH NAMA
        const inputSearch = filterForm.querySelector('input[name="search"]');
        if (inputSearch) {
            inputSearch.addEventListener('input', () => {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => {
                    submitFilter();
                }, 400);
            });
        }

        // AUTO SUBMIT SAAT DROPDOWN BERUBAH
        const selectStatus = filterForm.querySelector('select[name="status_santri"]');
        if (selectStatus) {
            selectStatus.addEventListener('change', submitFilter);
        }
    });
</script>
@endsection