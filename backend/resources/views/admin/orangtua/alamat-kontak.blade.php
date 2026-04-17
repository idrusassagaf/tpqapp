@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between gap-4 mb-3">
        <div>
            <h1 class="text-2xl font-extralight tracking-wide text-slate-800">
                Alamat & Kontak Orang Tua
            </h1>
            <p class="text-sm text-slate-500 font-light mt-1">
                Data otomatis dari relasi orang tua. Alamat & kontak bisa diedit inline.
            </p>
        </div>

        <div class="text-right">
            <div class="text-sm text-slate-600 font-extralight tracking-wide">
                Total Data: <span class="font-medium text-slate-800">{{ $orangtuas->count() }}</span>
            </div>
        </div>
    </div>

    {{-- FILTER + SEARCH --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-4">

        <form id="filterForm" method="GET" action="{{ route('orangtua.alamat-kontak') }}"
            class="px-3 py-2 border-b border-slate-200 bg-gray-100">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">

                {{-- SEARCH NAMA --}}
                <div>
                    <label class="text-slate-600 text-xs font-extralight">Nama Ayah / Ibu</label>
                    <input type="text"
                        id="searchNama"
                        name="search_nama"
                        value="{{ request('search_nama') }}"
                        placeholder="Cari Nama Ayah/Ibu..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                           focus:outline-none focus:ring-2 focus:ring-sky-200">
                </div>

                {{-- SEARCH ALAMAT --}}
                <div>
                    <label class="text-slate-600 text-xs font-extralight">Alamat</label>
                    <input type="text"
                        id="searchAlamat"
                        name="search_alamat"
                        value="{{ request('search_alamat') }}"
                        placeholder="Cari Alamat..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                           focus:outline-none focus:ring-2 focus:ring-sky-200">
                </div>

                {{-- RESET --}}
                <div>
                    <a href="{{ route('orangtua.alamat-kontak') }}"
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
                        <th class="px-2 py-1 w-[55px] text-center font-normal">No</th>
                        <th class="px-2 py-1 w-[220px] font-normal">Nama Ayah</th>
                        <th class="px-2 py-1 w-[220px] font-normal">Nama Ibu</th>
                        <th class="px-2 py-1 font-normal">Alamat</th>
                        <th class="px-2 py-1 w-[180px] font-normal">No. Kontak</th>
                        @if(auth()->user()->isAdmin())
                        <th class="px-2 py-1 w-[120px] text-center font-normal">Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($orangtuas as $i => $o)
                    <tr data-id="{{ $o->id }}" class="hover:bg-slate-50/60 transition">

                        <td class="px-2 py-1 text-center text-slate-600">
                            {{ $i + 1 }}
                        </td>

                        <td class="px-2 py-1">
                            <div class="font-light text-slate-800">
                                {{ $o->nama_ayah ?? '-' }}
                            </div>
                        </td>

                        <td class="px-2 py-1">
                            <div class="font-light text-slate-800">
                                {{ $o->nama_ibu ?? '-' }}
                            </div>
                        </td>

                        <td class="px-2 py-1 alamat text-slate-700">
                            {{ $o->alamat ?? '-' }}
                        </td>

                        <td class="px-2 py-1 kontak text-slate-700">
                            {{ $o->no_kontak ?? '-' }}
                        </td>

                        @if(auth()->user()->isAdmin())
                        <td class="px-2 py-1 text-center">
                            <button type="button"
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
        const searchNama = document.getElementById('searchNama');
        const searchAlamat = document.getElementById('searchAlamat');

        let typingTimer;

        function liveSubmit() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                filterForm.submit();
            }, 350);
        }

        if (searchNama) searchNama.addEventListener('input', liveSubmit);
        if (searchAlamat) searchAlamat.addEventListener('input', liveSubmit);

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

                    const alamat = alamatCell.querySelector('input').value;
                    const kontak = kontakCell.querySelector('input').value;

                    fetch(`/orangtua/${id}/update-alamat`, {
                            method: 'POST',
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