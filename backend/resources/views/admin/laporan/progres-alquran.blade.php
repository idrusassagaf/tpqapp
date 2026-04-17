@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between gap-4 mb-3">
        <div>
            <h1 class="text-2xl font-extralight tracking-wide text-slate-800">
                Laporan Progres Al Quran
            </h1>
            <p class="text-sm text-slate-500 font-light mt-1">
                Update progres Al Quran santri Juz, Halaman, Guru.
            </p>
        </div>

        {{-- INFO (KANAN ATAS) --}}
        <div class="text-right">
            <div class="text-sm text-slate-600 font-extralight tracking-wide">
                Total Santri: <span class="font-medium text-slate-800">{{ $santris->count() }}</span>
            </div>
            <div class="text-xs text-slate-400 font-light mt-1">
                Auto: Sudah LCR → Lanjut dan Belum LCR → Ulang
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        {{-- FILTER + SEARCH --}}
        <form method="GET" action="/laporan/progres-alquran"
            class="px-3 py-2 border-b border-slate-200 bg-gray-100">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

                {{-- SEARCH NAMA SANTRI --}}
                <input type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Nama Santri"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
            focus:outline-none focus:ring-2 focus:ring-sky-200" />

                {{-- FILTER GURU --}}
                <select name="guru"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
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
                    class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
            focus:outline-none focus:ring-2 focus:ring-sky-200">
                    <option value="">Semua L/U</option>
                    <option value="Lanjut" {{ request('ulang_lanjut') == 'Lanjut' ? 'selected' : '' }}>Lanjut</option>
                    <option value="Ulang" {{ request('ulang_lanjut') == 'Ulang' ? 'selected' : '' }}>Ulang</option>
                </select>

                {{-- RESET --}}
                <a href="/laporan/progres-alquran"
                    class="w-full rounded-xl border border-slate-200 bg-white text-slate-700 px-4 py-2 text-sm font-extralight hover:bg-slate-50 transition text-center">
                    Reset
                </a>

            </div>
        </form>


        <div class="overflow-x-auto w-full">
            <table class="min-w-full text-xs table-fixed">
                <thead class="bg-slate-200 text-slate-600">
                    <tr class="text-left">
                        <th class="px-2 py-1 w-[40px]">No</th>
                        <th class="px-2 py-1 w-[180px]">Nama + NIS</th>
                        <th class="px-2 py-1 w-[220px]">Juz + Hal + Guru</th>
                        <th class="px-2 py-1 w-[120px] text-center">Progres</th>
                        @if(auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin')
                        <th class="px-2 py-1 w-[100px] text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($santris as $i => $s)
                    @php
                    $p = $progresMap[$s->id] ?? null;
                    $juz = $p->juz ?? '';
                    $hal = $p->hal ?? '';
                    $progres = $p->progres ?? '';
                    $guru = $s->guru->nama ?? '-';
                    @endphp
                    <tr data-id="{{ $p->id ?? '' }}"
                        data-santri-id="{{ $s->id }}"
                        data-guru-id="{{ $s->guru->id ?? '' }}"
                        class="hover:bg-slate-50/60 transition">

                        {{-- NO --}}
                        <td class="px-2 py-1 text-slate-500 font-extralight">{{ $i + 1 }}</td>

                        {{-- NAMA + NIS --}}
                        <td class="px-2 py-1">
                            <div class="font-medium text-slate-800">{{ $s->nama }}</div>
                            <div class="text-[10px] text-slate-500 font-extralight mt-0.5">
                                NIS: <span class="text-slate-700">{{ $s->nis ?? '-' }}</span>
                            </div>
                        </td>

                        {{-- JUZ + HAL + GURU --}}
                        <td class="px-2 py-1">
                            <div class="flex items-center gap-1 flex-wrap mb-0.5">
                                <input type="text" name="juz" value="{{ $juz }}" placeholder="Juz"
                                    class="w-[40px] rounded-xl border border-slate-400 px-2 py-0.5 text-xs focus:outline-none focus:ring-1 focus:ring-sky-200 text-center" disabled />

                                <input type="text" name="hal" value="{{ $hal }}" placeholder="Hal"
                                    class="w-[40px] rounded-xl border border-slate-400 px-2 py-0.5 text-xs focus:outline-none focus:ring-1 focus:ring-sky-200" disabled />
                            </div>
                            <div class="text-[10px] text-slate-500 font-medium">
                                Guru: {{ $guru }}
                            </div>
                        </td>

                        {{-- PROGRES --}}
                        <td class="px-2 py-1 text-center">
                            <select name="progres"
                                class="progres-dropdown w-auto rounded-xl font-medium border border-slate-400 px-6 py-0.5 text-xs focus:outline-none focus:ring-1 focus:ring-sky-200" disabled>
                                <option value="">-- Pilih --</option>
                                <option value="Sudah LCR" {{ $progres=='Sudah LCR' ? 'selected' : '' }}>Sudah LCR</option>
                                <option value="Belum LCR" {{ $progres=='Belum LCR' ? 'selected' : '' }}>Belum LCR</option>
                            </select>
                            <div class="text-[10px] text-slate-500 font-medium mt-0.5 keterangan">
                                {{ $progres=='Sudah LCR' ? 'Lanjut' : ($progres=='Belum LCR' ? 'Ulang' : '') }}
                            </div>
                        </td>

                        {{-- AKSI --}}
                        @if(auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin')
                        <td class="px-2 py-1 text-center">
                            <button class="action-btn inline-flex items-center justify-center px-2 py-0.5 rounded-xl bg-slate-400 text-white text-xs font-extralight hover:bg-slate-800 transition shadow-sm">
                                Edit
                            </button>
                        </td>
                        @endif

                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-2 py-6 text-center text-slate-500 font-extralight">
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

        // update keterangan saat dropdown berubah
        document.querySelectorAll('.progres-dropdown').forEach(dropdown => {
            dropdown.addEventListener('change', function() {
                const keterangan = this.closest('tr').querySelector('.keterangan');
                if (this.value === 'Sudah LCR') keterangan.textContent = 'Lanjut';
                else if (this.value === 'Belum LCR') keterangan.textContent = 'Ulang';
                else keterangan.textContent = '';
            });
        });

        // tombol edit / simpan
        document.querySelectorAll('.action-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const inputs = row.querySelectorAll('input, select');

                if (this.textContent.trim() === 'Edit') {
                    // Enable input
                    inputs.forEach(i => i.removeAttribute('disabled'));
                    this.textContent = 'Simpan';
                } else {
                    // Simpan data
                    const id = row.dataset.id || 0;
                    const santriId = row.dataset.santriId;
                    const guruId = row.dataset.guruId;
                    const juz = row.querySelector('input[name="juz"]').value;
                    const hal = row.querySelector('input[name="hal"]').value;
                    const progres = row.querySelector('select[name="progres"]').value;

                    fetch(`/laporan/progres-alquran/${id}/update`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                juz,
                                hal,
                                progres,
                                santri_id: santriId,
                                guru_id: guruId
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                alert('Data berhasil disimpan!');
                                inputs.forEach(i => i.setAttribute('disabled', ''));
                                btn.textContent = 'Edit';
                                if (!id) row.dataset.id = data.id;
                            } else {
                                alert('Gagal menyimpan: ' + (data.message || 'Unknown error'));
                            }
                        })
                        .catch(err => alert('Terjadi error: ' + err));
                }
            });
        });

        // ===============================
        // AUTO FILTER (LIVE SEARCH)
        // ===============================
        const filterForm = document.querySelector('form[action="/laporan/progres-alquran"]');

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
            const selectGuru = filterForm.querySelector('select[name="guru"]');
            const selectLU = filterForm.querySelector('select[name="ulang_lanjut"]');

            [selectGuru, selectLU].forEach(el => {
                if (!el) return;
                el.addEventListener('change', () => {
                    submitFilter();
                });
            });
        }

    });
</script>
@endsection