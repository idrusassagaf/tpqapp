@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between gap-4 mb-3">
        <div>
            <h1 class="text-2xl font-extralight tracking-wide text-slate-800">
                Pendidikan Guru
            </h1>
            <p class="text-xs text-slate-500 font-light mt-1">
                Data pendidikan terakhir guru otomatis dari Form Pendaftaran Guru. Edit bisa langsung inline.
            </p>
        </div>

        <div class="text-right">
            <div class="text-sm text-slate-600 font-extralight tracking-wide">
                Total Guru: <span class="font-medium text-slate-800">{{ $gurus->total() }}</span>
            </div>
        </div>
    </div>

    {{-- FILTER + SEARCH (CARD) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-4">

        <form id="filterForm" method="GET" action="{{ route('guru.pendidikan') }}"
            class="px-3 py-2 border-b border-slate-200 bg-gray-100">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">

                {{-- SEARCH NAMA --}}
                <div>
                    <label class="text-slate-600 text-xs font-extralight">Nama / NIG</label>
                    <input type="text"
                        id="searchNamaInput"
                        name="search_nama"
                        value="{{ request('search_nama') }}"
                        placeholder="Cari Nama atau NIG..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                        focus:outline-none focus:ring-2 focus:ring-sky-200">
                </div>

                {{-- SEARCH PENDIDIKAN --}}
                <div>
                    <label class="text-slate-600 text-xs font-extralight">Pendidikan</label>
                    <input type="text"
                        id="searchPendidikanInput"
                        name="search_pendidikan"
                        value="{{ request('search_pendidikan') }}"
                        placeholder="Cari Pendidikan Guru..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                        focus:outline-none focus:ring-2 focus:ring-sky-200">
                </div>

                {{-- RESET --}}
                <div>
                    <a href="{{ route('guru.pendidikan') }}"
                        class="block w-full rounded-xl border border-slate-200 bg-white text-slate-700
                        px-4 py-2 text-sm font-extralight hover:bg-slate-50 transition text-center">
                        Reset
                    </a>
                </div>
                <a href="{{ route('guru.pendidikan.export') }}"
                    class="block w-full rounded-xl border border-slate-200 bg-white text-slate-700
                        px-4 py-2 text-sm font-extralight hover:bg-slate-300 transition text-center">
                    Download Pendidikan Guru
                </a>
            </div>
        </form>

        {{-- TABLE --}}
        <div class="overflow-x-auto w-full">
            <table class="min-w-full text-xs table-fixed">
                <thead class="bg-slate-200 text-slate-600">
                    <tr class="text-left">
                        <th class="px-2 py-1 w-[55px] text-center font-normal">No</th>
                        <th class="px-2 py-1 font-normal">Nama Guru</th>
                        <th class="px-2 py-1 w-[120px] text-center font-normal">NIG</th>
                        <th class="px-2 py-1 font-normal">Pendidikan</th>
                        @if(auth()->user()->isAdmin())
                        <th class="px-2 py-1 w-[120px] text-center font-normal">Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($gurus as $i => $g)
                    <tr data-id="{{ $g->id }}" class="hover:bg-slate-50/60 transition">

                        <td class="px-2 py-1 text-center text-slate-600">
                            {{ ($gurus->currentPage() - 1) * $gurus->perPage() + $i + 1 }}
                        </td>

                        <td class="px-2 py-1">
                            <div class="font-light text-slate-800">
                                {{ $g->nama ?? '-' }}
                            </div>
                        </td>

                        <td class="px-2 py-1 text-center text-slate-600">
                            {{ $g->nig ?? '-' }}
                        </td>

                        <td class="px-2 py-1 pendidikan text-slate-700">
                            {{ $g->pendidikan ?? '-' }}
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
                        <td colspan="5" class="px-2 py-6 text-center text-slate-500 font-extralight">
                            @else
                        <td colspan="4" class="px-2 py-6 text-center text-slate-500 font-extralight">
                            @endif
                            Data guru belum ada.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

    {{-- PAGINATION --}}
    <div class="mt-3">
        {{ $gurus->links() }}
    </div>

</div>

{{-- SCRIPT FILTER (LIVE) --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const filterForm = document.getElementById('filterForm');
        const searchNamaInput = document.getElementById('searchNamaInput');
        const searchPendidikanInput = document.getElementById('searchPendidikanInput');

        let typingTimer;

        function liveSubmit() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                filterForm.submit();
            }, 350);
        }

        if (searchNamaInput) searchNamaInput.addEventListener('input', liveSubmit);
        if (searchPendidikanInput) searchPendidikanInput.addEventListener('input', liveSubmit);

    });
</script>

{{-- SCRIPT EDIT INLINE --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('.editBtn').forEach(button => {

            button.addEventListener('click', function() {

                const row = this.closest('tr');
                const id = row.dataset.id;

                const pendidikanCell = row.querySelector('.pendidikan');

                if (this.textContent.trim() === 'Edit') {

                    const pendidikanValue = pendidikanCell.textContent.trim() === '-' ? '' : pendidikanCell.textContent.trim();

                    pendidikanCell.innerHTML = `
                    <input type="text"
                           value="${pendidikanValue}"
                           placeholder="Isi pendidikan..."
                           class="w-full rounded-xl border border-slate-300 px-3 py-1 text-xs bg-white
                           focus:outline-none focus:ring-2 focus:ring-sky-200">
                `;

                    this.textContent = 'Simpan';

                    // slate mode
                    this.classList.remove('bg-slate-400', 'hover:bg-slate-800');
                    this.classList.add('bg-slate-900', 'hover:bg-slate-700');

                } else {

                    const pendidikan = pendidikanCell.querySelector('input').value;

                    fetch(`/guru/${id}/update-pendidikan`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                pendidikan: pendidikan
                            })
                        })
                        .then(res => res.json())
                        .then(data => {

                            if (data.success) {

                                pendidikanCell.textContent = pendidikan || '-';

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