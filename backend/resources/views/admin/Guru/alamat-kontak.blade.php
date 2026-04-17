@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between gap-4 mb-3">
        <div>
            <h1 class="text-2xl font-extralight tracking-wide text-slate-800">
                Alamat & Kontak Guru
            </h1>
            <p class="text-xs text-slate-500 font-light mt-1">
                Data otomatis dari Form Pendaftaran Guru. Edit bisa langsung inline.
            </p>
        </div>

        <div class="text-right">
            <div class="text-sm text-slate-600 font-extralight tracking-wide">
                Total Guru: <span class="font-medium text-slate-800">{{ $gurus->count() }}</span>
            </div>
        </div>
    </div>

    {{-- FILTER + SEARCH (CARD) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-4">

        <form id="filterForm" method="GET" action="{{ route('guru.alamat-kontak') }}"
            class="px-3 py-2 border-b border-slate-200 bg-gray-100">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">

                {{-- SEARCH NAMA --}}
                <div>
                    <label class="text-slate-600 text-xs font-extralight">Nama Guru / NIG</label>
                    <input type="text"
                        id="searchInput"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari Nama Guru / NIG..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                        focus:outline-none focus:ring-2 focus:ring-sky-200">
                </div>

                {{-- SEARCH ALAMAT --}}
                <div>
                    <label class="text-slate-600 text-xs font-extralight">Alamat</label>
                    <input type="text"
                        id="alamatInput"
                        name="alamat"
                        value="{{ request('alamat') }}"
                        placeholder="Cari Alamat..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                        focus:outline-none focus:ring-2 focus:ring-sky-200">
                </div>

                {{-- RESET --}}
                <div>
                    <a href="{{ route('guru.alamat-kontak') }}"
                        class="block w-full rounded-xl border border-slate-200 bg-white text-slate-700
                        px-3 py-2 text-sm font-extralight hover:bg-slate-50 transition text-center">
                        Reset
                    </a>

                </div>
                <a href="{{ route('guru-alamat-kontak.export.pdf') }}"
                    class="w-full rounded-xl border border-slate-200 bg-white text-slate-700 px-4 py-2 text-sm font-extralight
                   hover:bg-slate-300 transition text-center">
                    Download Alamat & Kontak
                </a>
            </div>
        </form>

        {{-- TABLE --}}
        <div class="overflow-x-auto w-full">
            <table class="min-w-full text-xs table-fixed">
                <thead class="bg-slate-200 text-slate-600">
                    <tr class="text-left">
                        <th class="px-2 py-1 w-[55px] text-center font-normal">No</th>
                        <th class="px-2 py-1 w-[110px] text-center font-normal">NIG</th>
                        <th class="px-2 py-1 w-[220px] font-normal">Nama Guru</th>
                        <th class="px-2 py-1 font-normal">Alamat</th>
                        <th class="px-2 py-1 w-[180px] font-normal">No. Kontak</th>
                        @if(auth()->user()->isAdmin())
                        <th class="px-2 py-1 w-[120px] text-center font-normal">Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($gurus as $i => $g)
                    <tr data-id="{{ $g->id }}" class="hover:bg-slate-50/60 transition">

                        <td class="px-2 py-1 text-center text-slate-600">
                            {{ $i + 1 }}
                        </td>

                        <td class="px-2 py-1 text-center text-slate-600">
                            {{ $g->nig ?? '-' }}
                        </td>

                        <td class="px-2 py-1">
                            <div class="font-light text-slate-800">
                                {{ $g->nama ?? '-' }}
                            </div>
                        </td>

                        <td class="px-2 py-1 alamat text-slate-700">
                            {{ $g->alamat ?? '-' }}
                        </td>

                        <td class="px-2 py-1 kontak text-slate-700">
                            {{ $g->no_kontak ?? '-' }}
                        </td>

                        @if(auth()->user()->isAdmin())
                        <td class="px-2 py-1 text-center">
                            <button
                                type="button"
                                class="editBtn inline-flex items-center justify-center px-2 py-0.5 rounded-xl
        bg-slate-400 text-white text-xs font-extralight hover:bg-slate-800 transition shadow-sm">
                                Edit
                            </button>
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
                            Data guru belum ada.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

{{-- SCRIPT FILTER (LIVE) --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const filterForm = document.getElementById('filterForm');
        const searchInput = document.getElementById('searchInput');
        const alamatInput = document.getElementById('alamatInput');

        let typingTimer;

        function liveSubmit() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                filterForm.submit();
            }, 350);
        }

        if (searchInput) searchInput.addEventListener('input', liveSubmit);
        if (alamatInput) alamatInput.addEventListener('input', liveSubmit);
    });
</script>

{{-- SCRIPT EDIT INLINE --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('.editBtn').forEach(button => {

            button.addEventListener('click', function() {

                const row = this.closest('tr');
                const id = row.dataset.id;

                const alamatCell = row.querySelector('.alamat');
                const kontakCell = row.querySelector('.kontak');

                if (this.textContent.trim() === 'Edit') {

                    const alamatValue = alamatCell.textContent.trim() === '-' ? '' : alamatCell.textContent.trim();
                    const kontakValue = kontakCell.textContent.trim() === '-' ? '' : kontakCell.textContent.trim();

                    alamatCell.innerHTML = `
                    <input type="text"
                           value="${alamatValue}"
                           placeholder="Isi alamat..."
                           class="w-full rounded-xl border border-slate-300 px-3 py-1 text-xs bg-white
                           focus:outline-none focus:ring-2 focus:ring-sky-200">
                `;

                    kontakCell.innerHTML = `
                    <input type="text"
                           value="${kontakValue}"
                           placeholder="Isi no. kontak..."
                           maxlength="30"
                           class="w-full rounded-xl border border-slate-300 px-3 py-1 text-xs bg-white
                           focus:outline-none focus:ring-2 focus:ring-sky-200">
                `;

                    this.textContent = 'Simpan';

                    this.classList.remove('bg-slate-400', 'hover:bg-slate-800');
                    this.classList.add('bg-slate-900', 'hover:bg-slate-700');

                } else {

                    const alamatInputEl = alamatCell.querySelector('input');
                    const kontakInputEl = kontakCell.querySelector('input');

                    const alamat = alamatInputEl ? alamatInputEl.value : '';
                    const kontak = kontakInputEl ? kontakInputEl.value : '';

                    fetch(`/guru/${id}/update-alamat-kontak`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                alamat: alamat,
                                no_kontak: kontak
                            })
                        })
                        .then(res => res.json())
                        .then(data => {

                            if (data.success) {

                                alamatCell.textContent = alamat || '-';
                                kontakCell.textContent = kontak || '-';

                                this.textContent = 'Edit';

                                this.classList.remove('bg-slate-900', 'hover:bg-slate-700');
                                this.classList.add('bg-slate-400', 'hover:bg-slate-800');

                            } else {
                                alert('Gagal update data!');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Terjadi kesalahan server!');
                        });

                }

            });

        });

    });
</script>
@endsection