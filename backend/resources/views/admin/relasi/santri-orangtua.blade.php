@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6 px-4">

    {{-- HEADER --}}
    <div class="flex items-center justify-between gap-4 mb-2">
        <div>
            <h2 class="text-2xl font-extralight tracking-wide text-slate-800">
                Relasi Santri + Orang Tua
            </h2>

            <p class="text-xs text-slate-500 font-light mt-1">
                Data otomatis muncul dari Form Pendaftaran Santri. Untuk melihat Status Orang Tua silahkan
                <a href="{{ url('/orangtua') }}" class="text-sky-600 hover:underline">
                    Klik di sini
                </a>.
            </p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-3 px-4 py-2 bg-green-100 text-green-800 rounded-xl shadow-sm text-sm">
        {{ session('success') }}
    </div>
    @endif

    {{-- FILTER --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-4">

        <div class="px-3 py-2 border-b border-slate-200 bg-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">

                {{-- FILTER SANTRI --}}
                <div>
                    <label class="text-slate-600 text-xs font-extralight">Nama Santri</label>
                    <input type="text" id="searchSantri" placeholder="Cari santri..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                        focus:outline-none focus:ring-2 focus:ring-sky-200">
                </div>

                {{-- FILTER AYAH --}}
                <div>
                    <label class="text-slate-600 text-xs font-extralight">Nama Ayah</label>
                    <input type="text" id="searchAyah" placeholder="Cari ayah..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                        focus:outline-none focus:ring-2 focus:ring-sky-200">
                </div>

                {{-- FILTER IBU --}}
                <div>
                    <label class="text-slate-600 text-xs font-extralight">Nama Ibu</label>
                    <input type="text" id="searchIbu" placeholder="Cari ibu..."
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
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto w-full">
            <table class="min-w-full text-xs table-fixed">
                <thead class="bg-slate-200 text-slate-600">
                    <tr>
                        <th class="px-2 py-1 w-[55px] text-center font-normal">No</th>
                        <th class="px-2 py-1 font-normal">Santri</th>
                        <th class="px-2 py-1 w-[250px] font-normal">Ayah</th>
                        <th class="px-2 py-1 w-[250px] font-normal">Ibu</th>
                        @if(auth()->user()->isAdmin())
                        <th class="px-2 py-1 w-[150px] text-center font-normal">Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody id="tableBody" class="divide-y divide-slate-100">
                    @foreach($santris as $i => $santri)
                    <tr class="hover:bg-slate-50/60 transition"
                        id="row-{{ $santri->id }}"
                        data-santri="{{ strtolower($santri->nama) }}"
                        data-ayah="{{ strtolower($santri->orangtua->nama_ayah ?? '') }}"
                        data-ibu="{{ strtolower($santri->orangtua->nama_ibu ?? '') }}">

                        <td class="px-2 py-1 text-center text-slate-600 nomor">
                            {{ $i+1 }}
                        </td>

                        <td class="px-2 py-1 text-slate-800 font-light">
                            {{ $santri->nama }}
                        </td>

                        {{-- FORM HARUS DI DALAM TD (SUPAYA HTML VALID) --}}
                        <td class="px-2 py-1">
                            <form action="{{ route('relasi.santri_orangtua.store', $santri->id) }}"
                                method="POST"
                                class="flex items-center gap-2 w-full form-row">
                                @csrf
                                <input type="hidden" name="santri_id" value="{{ $santri->id }}">

                                <input type="text"
                                    name="nama_ayah"
                                    value="{{ $santri->orangtua->nama_ayah ?? '' }}"
                                    placeholder="Nama Ayah"
                                    class="ayah-input w-full rounded-xl border border-slate-300 px-3 py-1 text-xs bg-white
    focus:outline-none focus:ring-2 focus:ring-sky-200"
                                    {{ auth()->user()->isAdmin() ? '' : 'readonly' }}>
                        </td>

                        <td class="px-2 py-1">
                            <input type="text"
                                name="nama_ibu"
                                value="{{ $santri->orangtua->nama_ibu ?? '' }}"
                                placeholder="Nama Ibu"
                                class="ibu-input w-full rounded-xl border border-slate-300 px-3 py-1 text-xs bg-white
    focus:outline-none focus:ring-2 focus:ring-sky-200"
                                {{ auth()->user()->isAdmin() ? '' : 'readonly' }}>
                        </td>

                        @if(auth()->user()->isAdmin())
                        <td class="px-2 py-1 text-center whitespace-nowrap">
                            <button type="button"
                                class="edit-btn inline-flex items-center justify-center px-2 py-0.5 rounded-xl
                            bg-slate-400 text-white text-xs font-extralight hover:bg-slate-800 transition shadow-sm"
                                data-id="{{ $santri->id }}">
                                Edit
                            </button>

                            <button type="submit"
                                class="save-btn inline-flex items-center justify-center px-2 py-0.5 rounded-xl
                                bg-slate-900 text-white text-xs font-extralight hover:bg-slate-700 transition shadow-sm hidden"
                                data-id="{{ $santri->id }}">
                                Simpan
                            </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- SCRIPT: FILTER LIVE --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const searchSantri = document.getElementById('searchSantri');
        const searchAyah = document.getElementById('searchAyah');
        const searchIbu = document.getElementById('searchIbu');
        const resetBtn = document.getElementById('resetFilter');

        const rows = document.querySelectorAll('#tableBody tr');

        function applyFilter() {

            const qSantri = (searchSantri.value || '').toLowerCase().trim();
            const qAyah = (searchAyah.value || '').toLowerCase().trim();
            const qIbu = (searchIbu.value || '').toLowerCase().trim();

            let nomor = 1;

            rows.forEach(row => {

                const santri = row.dataset.santri || '';
                const ayah = row.dataset.ayah || '';
                const ibu = row.dataset.ibu || '';

                const okSantri = santri.includes(qSantri);
                const okAyah = ayah.includes(qAyah);
                const okIbu = ibu.includes(qIbu);

                if (okSantri && okAyah && okIbu) {
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
        searchAyah.addEventListener('input', liveFilter);
        searchIbu.addEventListener('input', liveFilter);

        resetBtn.addEventListener('click', function() {
            searchSantri.value = '';
            searchAyah.value = '';
            searchIbu.value = '';
            applyFilter();
        });

    });
</script>

{{-- SCRIPT: EDIT + SIMPAN --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {

                const id = this.dataset.id;
                const row = document.getElementById(`row-${id}`);

                const ayahInput = row.querySelector('.ayah-input');
                const ibuInput = row.querySelector('.ibu-input');

                ayahInput.removeAttribute('readonly');
                ibuInput.removeAttribute('readonly');

                this.classList.add('hidden');
                row.querySelector('.save-btn').classList.remove('hidden');

            });
        });

    });
</script>
@endsection