@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between gap-4 mb-3">
        <div>
            <h1 class="text-2xl font-extralight tracking-wide text-slate-800">
                Status Guru
            </h1>
            <p class="text-xs text-slate-500 font-light mt-1">
                Kehadiran diisi manual. Status guru akan otomatis berubah sesuai pilihan kehadiran.
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

        <form id="filterForm" method="GET" action="{{ route('guru.status') }}"
            class="px-3 py-2 border-b border-slate-200 bg-gray-100">

            <div class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">

                {{-- SEARCH --}}
                <div>
                    <label class="text-slate-600 text-xs font-extralight">Nama / NIG</label>
                    <input type="text"
                        id="searchInput"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari Nama atau NIG..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                        focus:outline-none focus:ring-2 focus:ring-sky-200">
                </div>

                {{-- FILTER KEHADIRAN --}}
                <div>
                    <label class="text-slate-600 text-xs font-extralight">Kehadiran</label>
                    <select name="kehadiran" onchange="this.form.submit()"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                        focus:outline-none focus:ring-2 focus:ring-sky-200">
                        <option value="">-- Semua --</option>
                        <option value="Alpa < 5 Hr" {{ request('kehadiran')=='Alpa < 5 Hr' ? 'selected' : '' }}>
                            Alpa &lt; 5 Hr
                        </option>
                        <option value="Alpa < 10 Hr" {{ request('kehadiran')=='Alpa < 10 Hr' ? 'selected' : '' }}>
                            Alpa &lt; 10 Hr
                        </option>
                        <option value="Alpa > 10 Hr" {{ request('kehadiran')=='Alpa > 10 Hr' ? 'selected' : '' }}>
                            Alpa &gt; 10 Hr
                        </option>
                    </select>
                </div>

                {{-- FILTER STATUS --}}
                <div>
                    <label class="text-slate-600 text-xs font-extralight">Status</label>
                    <select name="status" onchange="this.form.submit()"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                        focus:outline-none focus:ring-2 focus:ring-sky-200">
                        <option value="">-- Semua --</option>
                        <option value="Aktif" {{ request('status')=='Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Kurang Aktif" {{ request('status')=='Kurang Aktif' ? 'selected' : '' }}>Kurang Aktif</option>
                        <option value="Tidak Aktif" {{ request('status')=='Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                {{-- RESET --}}
                <div>
                    <a href="{{ route('guru.status') }}"
                        class="block w-full rounded-xl border border-slate-200 bg-white text-slate-700
                        px-4 py-2 text-sm font-extralight hover:bg-slate-50 transition text-center">
                        Reset
                    </a>
                </div>
                <a href="{{ route('guru.status.export') }}"
                    class="block w-full rounded-xl border border-slate-200 bg-white text-slate-700
                        px-4 py-2 text-sm font-extralight hover:bg-slate-300 transition text-center">
                    Download PDF
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
                        <th class="px-2 py-1 font-normal">Nama Guru</th>
                        <th class="px-2 py-1 w-[170px] text-center font-normal">Kehadiran</th>
                        <th class="px-2 py-1 w-[160px] text-center font-normal">Status</th>
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

                        <td class="px-2 py-1 text-center text-slate-600">
                            {{ $g->nig ?? '-' }}
                        </td>

                        <td class="px-2 py-1">
                            <div class="font-light text-slate-800">
                                {{ $g->nama ?? '-' }}
                            </div>
                        </td>

                        <td class="px-2 py-1 kehadiran text-center text-slate-700">
                            {{ $g->kehadiran ?? '-' }}
                        </td>

                        <td class="px-2 py-1 status_guru text-center text-slate-700">
                            {{ $g->status_guru ?? '-' }}
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

    {{-- PAGINATION --}}
    <div class="mt-3">
        {{ $gurus->links() }}
    </div>

</div>

{{-- SCRIPT FILTER LIVE --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const filterForm = document.getElementById('filterForm');
        const searchInput = document.getElementById('searchInput');

        let typingTimer;

        function liveSubmit() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                filterForm.submit();
            }, 350);
        }

        if (searchInput) searchInput.addEventListener('input', liveSubmit);

    });
</script>

{{-- SCRIPT INLINE EDIT --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        function statusOtomatis(kehadiran) {
            if (kehadiran === 'Alpa < 5 Hr') return 'Aktif';
            if (kehadiran === 'Alpa < 10 Hr') return 'Kurang Aktif';
            if (kehadiran === 'Alpa > 10 Hr') return 'Tidak Aktif';
            return '-';
        }

        document.querySelectorAll('.editBtn').forEach(button => {

            button.addEventListener('click', function() {

                const row = this.closest('tr');
                const id = row.dataset.id;

                const kehadiranCell = row.querySelector('.kehadiran');
                const statusCell = row.querySelector('.status_guru');

                if (this.textContent.trim() === 'Edit') {

                    const current = kehadiranCell.textContent.trim();

                    kehadiranCell.innerHTML = `
                    <select class="w-full rounded-xl border border-slate-300 px-3 py-1 text-xs bg-white
                                   focus:outline-none focus:ring-2 focus:ring-sky-200">
                        <option value="">-- Pilih --</option>
                        <option value="Alpa < 5 Hr">Alpa < 5 Hr</option>
                        <option value="Alpa < 10 Hr">Alpa < 10 Hr</option>
                        <option value="Alpa > 10 Hr">Alpa > 10 Hr</option>
                    </select>
                `;

                    const select = kehadiranCell.querySelector('select');
                    select.value = current === '-' ? '' : current;

                    select.addEventListener('change', function() {
                        statusCell.textContent = statusOtomatis(this.value);
                    });

                    this.textContent = 'Simpan';

                    // slate mode
                    this.classList.remove('bg-slate-400', 'hover:bg-slate-800');
                    this.classList.add('bg-slate-900', 'hover:bg-slate-700');

                } else {

                    const select = kehadiranCell.querySelector('select');
                    const kehadiran = select.value;

                    const formData = new FormData();
                    formData.append('kehadiran', kehadiran);

                    fetch(`/guru/${id}/update-status`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData

                        })
                        .then(res => res.json())
                        .then(data => {

                            if (data.success) {

                                kehadiranCell.textContent = kehadiran || '-';
                                statusCell.textContent = data.status || statusOtomatis(kehadiran) || '-';

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