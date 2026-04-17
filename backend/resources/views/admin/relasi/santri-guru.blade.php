@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6 px-4">

    {{-- HEADER --}}
    <div class="flex items-center justify-between gap-4 mb-3">
        <div>
            <h2 class="text-2xl font-extralight tracking-wide text-slate-800">
                Relasi Santri + Guru
            </h2>
            <p class="text-sx text-slate-500 font-light mt-1">
                Kelolah relasi data Santri dan Guru langsung dari tabel.
            </p>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-4">

        <form id="filterForm" method="GET" class="px-3 py-2 border-b border-slate-200 bg-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">

                {{-- NAMA SANTRI --}}
                <div>
                    <label class="text-slate-600 text-xs font-extralight">Nama Santri</label>
                    <input type="text" id="searchSantri" placeholder="Cari nama santri..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                           focus:outline-none focus:ring-2 focus:ring-sky-200">
                </div>

                {{-- KELAS --}}
                <div>
                    <label class="text-slate-600 text-xs font-extralight">Kelas</label>
                    <input type="text" id="searchKelas" placeholder="Cari kelas..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                           focus:outline-none focus:ring-2 focus:ring-sky-200">
                </div>

                {{-- NAMA GURU --}}
                <div>
                    <label class="text-slate-600 text-xs font-extralight">Nama Guru</label>
                    <input type="text" id="searchGuru" placeholder="Cari nama guru..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                           focus:outline-none focus:ring-2 focus:ring-sky-200">
                </div>

                {{-- RESET --}}
                <div>
                    <button type="button" id="resetFilter"
                        class="w-full rounded-xl border border-slate-200 bg-white text-slate-700
                        px-4 py-2 text-sm font-extralight hover:bg-slate-50 transition text-center">
                        Reset
                    </button>
                </div>

            </div>
        </form>

        {{-- TABLE --}}
        <div class="overflow-x-auto w-full">
            <table class="min-w-full text-xs table-fixed">
                <thead class="bg-slate-200 text-slate-600">
                    <tr class="text-left">
                        <th class="px-2 py-1 w-[55px] text-center font-normal">No</th>
                        <th class="px-2 py-1 font-normal">Nama Santri</th>
                        <th class="px-2 py-1 w-[140px] font-normal">Kelas</th>
                        <th class="px-2 py-1 w-[260px] font-normal">Nama Guru</th>
                        @if(auth()->user()->isAdmin())
                        <th class="px-2 py-1 w-[150px] text-center font-normal">Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody id="tableBody" class="divide-y divide-slate-100 text-xs">
                    @foreach($santris as $i => $s)
                    <tr class="hover:bg-slate-50/60 transition"
                        id="row-{{ $s->id }}"
                        data-santri="{{ strtolower($s->nama) }}"
                        data-kelas="{{ strtolower($s->kelas ?? '') }}"
                        data-guru="{{ strtolower($s->guru->nama ?? '') }}">

                        <td class="px-2 py-1 text-center text-slate-600 nomor">
                            {{ $i + 1 }}
                        </td>

                        <td class="px-2 py-1 text-slate-800 font-light">
                            {{ $s->nama }}
                        </td>

                        <td class="px-2 py-1">
                            <input type="text"
                                value="{{ $s->kelas }}"
                                class="kelas-input w-full rounded-xl border border-slate-300 px-3 py-1 text-xs
       text-slate-800 font-light bg-white
       focus:outline-none focus:ring-2 focus:ring-sky-200"
                                data-santri="{{ $s->id }}"
                                readonly>
                        </td>

                        <td class="px-2 py-1">
                            <select class="guru-select w-full rounded-xl border border-slate-300 px-3 py-1 text-xs
        text-slate-800 font-light bg-white
        focus:outline-none focus:ring-2 focus:ring-sky-200"
                                data-santri="{{ $s->id }}"
                                {{ auth()->user()->isAdmin() ? '' : 'disabled' }}>
                                <option value="">-- Pilih Guru --</option>
                                @foreach($gurus as $g)
                                <option value="{{ $g->id }}" {{ $s->guru_id == $g->id ? 'selected' : '' }}>
                                    {{ $g->nama }}
                                </option>
                                @endforeach
                            </select>
                        </td>

                        @if(auth()->user()->isAdmin())
                        <td class="px-2 py-1 text-center whitespace-nowrap">
                            <button type="button"
                                class="edit-btn inline-flex items-center justify-center px-2 py-0.5 rounded-xl
                                 bg-slate-400 text-white text-xs font-extralight hover:bg-slate-800 transition shadow-sm"
                                data-id="{{ $s->id }}">
                                Edit
                            </button>

                            <button type="button"
                                class="save-btn inline-flex items-center justify-center px-2 py-0.5 rounded-xl
                                bg-slate-900 text-white text-xs font-extralight hover:bg-slate-700 transition shadow-sm hidden"
                                data-id="{{ $s->id }}">
                                Simpan
                            </button>
                        </td>
                        @endif

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>

{{-- SCRIPT: FILTER LIVE (CLIENT SIDE) --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const searchSantri = document.getElementById('searchSantri');
        const searchKelas = document.getElementById('searchKelas');
        const searchGuru = document.getElementById('searchGuru');
        const resetBtn = document.getElementById('resetFilter');

        const rows = document.querySelectorAll('#tableBody tr');

        function applyFilter() {

            const qSantri = (searchSantri.value || '').toLowerCase().trim();
            const qKelas = (searchKelas.value || '').toLowerCase().trim();
            const qGuru = (searchGuru.value || '').toLowerCase().trim();

            let nomor = 1;

            rows.forEach(row => {

                const santri = row.dataset.santri || '';
                const kelas = row.dataset.kelas || '';
                const guru = row.dataset.guru || '';

                const okSantri = santri.includes(qSantri);
                const okKelas = kelas.includes(qKelas);
                const okGuru = guru.includes(qGuru);

                if (okSantri && okKelas && okGuru) {
                    row.classList.remove('hidden');

                    // update nomor
                    const nomorCell = row.querySelector('.nomor');
                    if (nomorCell) nomorCell.textContent = nomor;
                    nomor++;

                } else {
                    row.classList.add('hidden');
                }
            });
        }

        let typingTimer;

        function liveFilter() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                applyFilter();
            }, 250);
        }

        searchSantri.addEventListener('input', liveFilter);
        searchKelas.addEventListener('input', liveFilter);
        searchGuru.addEventListener('input', liveFilter);

        resetBtn.addEventListener('click', function() {
            searchSantri.value = '';
            searchKelas.value = '';
            searchGuru.value = '';
            applyFilter();
        });

    });
</script>

{{-- SCRIPT: EDIT + SAVE (TIDAK MERUSAK ROUTE) --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // EDIT
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {

                const id = this.dataset.id;
                const row = document.getElementById(`row-${id}`);

                row.querySelector('.kelas-input').removeAttribute('readonly');
                row.querySelector('.guru-select').removeAttribute('disabled');

                this.classList.add('hidden');
                row.querySelector('.save-btn').classList.remove('hidden');

            });
        });

        // SIMPAN
        document.querySelectorAll('.save-btn').forEach(btn => {
            btn.addEventListener('click', function() {

                const id = this.dataset.id;
                const row = document.getElementById(`row-${id}`);

                const kelas = row.querySelector('.kelas-input').value;
                const guru_id = row.querySelector('.guru-select').value;

                fetch("{{ route('relasi.update-guru') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            santri_id: id,
                            kelas: kelas,
                            guru_id: guru_id
                        })
                    })
                    .then(res => res.json())
                    .then(data => {

                        if (data.success) {

                            row.querySelector('.kelas-input').setAttribute('readonly', true);
                            row.querySelector('.guru-select').setAttribute('disabled', true);

                            this.classList.add('hidden');
                            row.querySelector('.edit-btn').classList.remove('hidden');

                            // update dataset guru + kelas supaya filter ikut update
                            const selectedText = row.querySelector('.guru-select').selectedOptions[0]?.textContent || '';
                            row.dataset.guru = selectedText.toLowerCase();
                            row.dataset.kelas = (kelas || '').toLowerCase();

                            // highlight sukses
                            row.querySelector('.kelas-input').classList.add('ring-2', 'ring-green-400');
                            row.querySelector('.guru-select').classList.add('ring-2', 'ring-green-400');

                            setTimeout(() => {
                                row.querySelector('.kelas-input').classList.remove('ring-2', 'ring-green-400');
                                row.querySelector('.guru-select').classList.remove('ring-2', 'ring-green-400');
                            }, 700);

                        } else {
                            alert('Gagal update data!');
                        }

                    })
                    .catch(err => {
                        console.error(err);
                        alert('Terjadi kesalahan server!');
                    });

            });
        });

    });
</script>
@endsection