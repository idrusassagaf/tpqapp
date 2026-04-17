@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between gap-4 mb-3">
        <div>
            <h1 class="text-2xl font-extralight tracking-wide text-slate-800">
                Laporan Progres Iqra
            </h1>
            <p class="text-sm text-slate-500 font-light mt-1">
                Update progres Iqra santri (Halaman, Status).
            </p>
        </div>

        {{-- INFO (KANAN ATAS) --}}
        <div class="text-right">
            <div class="text-sm text-slate-600 font-light tracking-wide">
                Total Santri: <span class="font-medium text-slate-800">{{ $santris->count() }}</span>
            </div>
            <div class="text-xs text-slate-400 font-medium mt-1">
                Auto: Sudah LCR → Lanjut, Belum LCR → Ulang
            </div>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        {{-- FILTER + SEARCH (LIVE) --}}
        <form id="filterForm" method="GET" action="{{ route('laporan.progres-iqra') }}"
            class="px-3 py-2 border-b border-slate-200 bg-gray-100">

            <div class="grid grid-cols-1 md:grid-cols-5 gap-3">

                {{-- SEARCH NAMA --}}
                <input type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Nama Santri"
                    class="js-filter w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                    focus:outline-none focus:ring-2 focus:ring-sky-200" />

                {{-- FILTER IQRA --}}
                <select name="iqra"
                    class="js-filter w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                    focus:outline-none focus:ring-2 focus:ring-sky-200">
                    <option value="">Semua Iqra</option>
                    @for($x=1;$x<=6;$x++)
                        <option value="Iqra {{ $x }}" {{ request('iqra')=="Iqra $x" ? 'selected' : '' }}>
                        Iqra {{ $x }}
                        </option>
                        @endfor
                </select>

                {{-- FILTER GURU --}}
                <select name="guru"
                    class="js-filter w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                    focus:outline-none focus:ring-2 focus:ring-sky-200">
                    <option value="">Semua Guru</option>
                    @foreach($guruList as $g)
                    <option value="{{ $g->id }}" {{ request('guru') == $g->id ? 'selected' : '' }}>
                        {{ $g->nama }}
                    </option>
                    @endforeach
                </select>

                {{-- FILTER LANJUT / ULANG --}}
                <select name="ulang_lanjut"
                    class="js-filter w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                    focus:outline-none focus:ring-2 focus:ring-sky-200">
                    <option value="">Semua L/U</option>
                    <option value="Lanjut" {{ request('ulang_lanjut') == 'Lanjut' ? 'selected' : '' }}>Lanjut</option>
                    <option value="Ulang" {{ request('ulang_lanjut') == 'Ulang' ? 'selected' : '' }}>Ulang</option>
                </select>

                {{-- RESET --}}
                <a href="{{ route('laporan.progres-iqra') }}"
                    class="w-full rounded-xl border border-slate-200 bg-white text-slate-700 px-4 py-2 text-sm font-extralight hover:bg-slate-50 transition text-center">
                    Reset
                </a>

            </div>
        </form>

        {{-- TABLE --}}
        <div class="overflow-x-auto w-full">
            <table class="min-w-full text-xs table-fixed">
                <thead class="bg-slate-200 text-slate-600">
                    <tr class="text-left">
                        <th class="px-2 py-1 w-[40px]">No</th>
                        <th class="px-2 py-1 w-[180px]">Nama + NIS</th>
                        <th class="px-2 py-1 w-[220px]">Iqra + Hal + Guru</th>
                        <th class="px-2 py-1 w-[120px] text-center">Progres</th>
                        @if(auth()->user()->isAdmin())
                        <th class="px-2 py-1 w-[100px] text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($santris as $i => $s)
                    @php
                    $p = $progresMap[$s->id] ?? null;

                    $kelas = $s->kelas ?? '-';
                    $hal = $p->hal ?? '';

                    $status = $p->status ?? 'Belum Lancar';
                    $statusLabel = $status === 'Lancar' ? 'Sudah LCR' : 'Belum LCR';
                    $ulangLanjutText = $status === 'Lancar' ? 'Lanjut' : 'Ulang';

                    $isEdit = request('edit') == $s->id;
                    @endphp

                    <tr class="hover:bg-slate-50/60 transition">

                        {{-- NO --}}
                        <td class="px-2 py-1 text-slate-500 font-extralight">{{ $i + 1 }}</td>

                        {{-- NAMA + NIS --}}
                        <td class="px-2 py-1">
                            <div class="font-medium text-slate-800">{{ $s->nama }}</div>
                            <div class="text-[10px] text-slate-500 font-extralight mt-0.5">
                                NIS: <span class="text-slate-700">{{ $s->nis ?? '-' }}</span>
                            </div>
                        </td>

                        {{-- IQRA + HAL + GURU --}}
                        <td class="px-2 py-1">
                            <div class="flex items-center gap-1 flex-wrap mb-0.5">

                                {{-- IQRA --}}
                                <input type="text" value="{{ $kelas }}"
                                    class="w-[50px] rounded-xl border border-slate-400 px-2 py-0.5 text-xs
                                    focus:outline-none focus:ring-1 focus:ring-sky-200"
                                    disabled />

                                {{-- HAL --}}
                                @if(!$isEdit)
                                <input type="text" value="{{ $hal }}"
                                    placeholder="Hal"
                                    class="w-[40px] rounded-xl border border-slate-400 px-2 py-0.5 text-xs text-center
                                        focus:outline-none focus:ring-1 focus:ring-sky-200"
                                    disabled />
                                @else
                                <form id="form-iqra-{{ $s->id }}" method="POST"
                                    action="{{ route('laporan.progres-iqra.update', $s->id) }}" class="inline">
                                    @csrf
                                    @method('PUT')

                                    <input type="number" name="hal" value="{{ $hal }}" placeholder="Hal"
                                        class="w-[60px] rounded-xl border border-slate-400 px-2 py-0.5 text-xs
                                        focus:outline-none focus:ring-1 focus:ring-sky-200"
                                        {{ auth()->user()->isAdmin() ? '' : 'disabled' }} />
                                    @endif

                            </div>

                            <div class="text-[10px] text-slate-500 font-medium">
                                Guru: {{ $s->guru->nama ?? '-' }}
                            </div>
                        </td>

                        {{-- PROGRES --}}
                        <td class="px-2 py-1 text-center">

                            @if(!$isEdit)
                            <select
                                class="progres-dropdown w-auto rounded-xl font-medium border border-slate-400 px-6 py-0.5 text-xs
                                    focus:outline-none focus:ring-1 focus:ring-sky-200"
                                disabled>
                                <option>{{ $statusLabel }}</option>
                            </select>

                            <div class="text-[10px] text-slate-500 font-medium mt-0.5 keterangan">
                                {{ $ulangLanjutText }}
                            </div>
                            @else
                            <select name="status"
                                class="progres-dropdown w-auto rounded-xl border border-slate-400 px-2 py-0.5 text-xs
                                focus:outline-none focus:ring-1 focus:ring-sky-200"
                                {{ auth()->user()->isAdmin() ? '' : 'disabled' }}>
                                <option value="Belum Lancar" {{ $status !== 'Lancar' ? 'selected' : '' }}>Belum LCR</option>
                                <option value="Lancar" {{ $status === 'Lancar' ? 'selected' : '' }}>Sudah LCR</option>
                            </select>

                            <div class="text-[10px] text-slate-500 font-extralight mt-0.5 keterangan">
                                {{ $ulangLanjutText }}
                            </div>
                            @endif
                        </td>

                        {{-- AKSI --}}

                        @if(auth()->user()->isAdmin())
                        <td class="px-2 py-1 text-center">
                            @if(!$isEdit)
                            <a href="{{ route('laporan.progres-iqra', array_merge(request()->query(), ['edit' => $s->id])) }}"
                                class="action-btn inline-flex items-center justify-center px-2 py-0.5 rounded-xl
                                bg-slate-400 text-white text-xs font-extralight hover:bg-slate-800 transition shadow-sm">
                                Edit
                            </a>
                            @else
                            <button type="submit" form="form-iqra-{{ $s->id }}"
                                class="action-btn inline-flex items-center justify-center px-2 py-0.5 rounded-xl
                                bg-slate-900 text-white text-xs font-extralight hover:bg-slate-800 transition shadow-sm">
                                Simpan
                            </button>
                            </form>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-2 py-6 text-center text-slate-500 font-extralight">
                            Data santri belum tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {

        // ===============================
        // AUTO FILTER (LIVE SEARCH)
        // ===============================
        const filterForm = document.getElementById('filterForm');

        if (filterForm) {
            let typingTimer;

            const submitFilter = () => {
                filterForm.submit();
            };

            // LIVE SEARCH NAMA
            const inputQ = filterForm.querySelector('input[name="q"]');
            if (inputQ) {
                inputQ.addEventListener('input', () => {
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(() => {
                        submitFilter();
                    }, 400);
                });
            }

            // AUTO SUBMIT SAAT DROPDOWN BERUBAH
            const selectIqra = filterForm.querySelector('select[name="iqra"]');
            const selectGuru = filterForm.querySelector('select[name="guru"]');
            const selectLU = filterForm.querySelector('select[name="ulang_lanjut"]');

            [selectIqra, selectGuru, selectLU].forEach(el => {
                if (!el) return;
                el.addEventListener('change', () => {
                    submitFilter();
                });
            });
        }

        // ===============================
        // UPDATE KETERANGAN SAAT DROPDOWN STATUS BERUBAH (MODE EDIT)
        // ===============================
        document.querySelectorAll('select[name="status"]').forEach(dropdown => {
            dropdown.addEventListener('change', function() {
                const ket = this.closest('td').querySelector('.keterangan');
                if (!ket) return;

                if (this.value === 'Lancar') ket.textContent = 'Lanjut';
                else ket.textContent = 'Ulang';
            });
        });

    });
</script>
@endsection