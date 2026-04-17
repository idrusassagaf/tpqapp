@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between gap-4 mb-3">
        <div>
            <h1 class="text-2xl font-extralight tracking-wide text-slate-800">
                Data Gender dan Usia Santri
            </h1>
            <p class="text-xs text-slate-500 font-light mt-1">
                Kelola data kelahiran dan usia santri.
            </p>
        </div>


    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
    <div class="mb-3 px-4 py-2 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm font-extralight">
        {{ session('success') }}
    </div>
    @endif

    {{-- SEARCH + FILTER (LIVE) --}}
    <form method="GET" action="{{ route('gender-usia.index') }}"
        class="px-3 py-2 border-b border-slate-200 bg-gray-100 rounded-xl mb-3">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">

            {{-- Search --}}
            <div>
                <input type="text"
                    name="search"
                    value="{{ $search ?? '' }}"
                    oninput="this.form.submit()"
                    placeholder="Ketik nama atau NIS..."
                    class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-200">
            </div>
            {{-- Filter Gender --}}
            <div>
                <select name="gender"
                    onchange="this.form.submit()"
                    class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-200">
                    <option value="">Semua Gender</option>
                    <option value="L" {{ ($gender ?? '')=='L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ ($gender ?? '')=='P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>


            {{-- Tombol Download PDF --}}
            <a href="{{ route('gender-usia.pdf', request()->query()) }}"
                class="w-full rounded-xl border border-slate-200 bg-white text-slate-700 px-4 py-2 text-sm font-extralight
                   hover:bg-slate-300 transition text-center">
                Download Gender & Usia
            </a>
        </div>
</div>
</form>

{{-- TABLE --}}
<div id="tableView" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto w-full">
        <table class="min-w-full text-xs table-fixed">

            <thead class="bg-slate-200 text-slate-600">
                <tr class="text-left">
                    <th class="px-3 py-2 w-[320px]">Nama Santri</th>
                    <th class="px-3 py-2 w-[90px] text-center">JK</th>
                    <th class="px-3 py-2 w-[180px] text-center">Tanggal Lahir</th>
                    <th class="px-3 py-2 w-[120px] text-center">Usia</th>
                    @if(auth()->user()->isAdmin())
                    <th class="px-3 py-2 w-[220px] text-center">Aksi</th>
                    @endif
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse ($santris as $s)
                <tr class="hover:bg-slate-50/60 transition"
                    x-data="{ 
                editing:false, 
                tgl:'{{ $s->tgl_lahir }}',
                tempat:'{{ $s->tempat_lahir }}'
            }">

                    {{-- Nama --}}
                    <td class="px-3 py-2 text-slate-700 font-extralight">
                        <div class="font-extralight text-slate-800">
                            {{ $s->nama }}
                        </div>

                        <div class="text-xs text-slate-500 font-extralight mt-1">
                            NIS: {{ $s->nis ?? '-' }}
                        </div>
                    </td>

                    {{-- JK --}}
                    <td class="px-3 py-2 text-center">
                        @if($s->jk)
                        <span class="inline-flex items-center justify-center w-8 py-0.5 rounded border border-slate-400 bg-white text-slate-700 text-xs font-medium">
                            {{ $s->jk }}
                        </span>
                        @else
                        <span class="text-slate-400 text-xs italic">-</span>
                        @endif
                    </td>


                    {{-- TGL LAHIR --}}
                    <td class="px-3 py-2 text-center text-slate-700 font-extralight">
                        <div x-show="!editing">
                            @if ($s->tgl_lahir)
                            {{ \Carbon\Carbon::parse($s->tgl_lahir)->format('d-m-Y') }}
                            @else
                            <span class="text-red-500 italic text-xs">Belum diisi</span>
                            @endif
                        </div>

                        <div x-show="editing" class="flex justify-center">
                            <form method="POST"
                                action="{{ route('gender-usia.update', $s->id) }}"
                                class="flex items-center gap-2">
                                @csrf
                                @method('PUT')

                                <input type="date"
                                    name="tgl_lahir"
                                    x-model="tgl"
                                    class="rounded-xl border border-slate-200 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-200">

                                <button type="submit"
                                    class="inline-flex items-center justify-center px-3 py-1 rounded-xl bg-green-600 text-white text-xs font-extralight hover:bg-green-700 transition shadow-sm"
                                    @click="editing=false">
                                    Simpan
                                </button>
                            </form>
                        </div>
                    </td>

                    {{-- USIA --}}
                    <td class="px-3 py-2 text-center text-slate-700 font-extralight">
                        @if ($s->tgl_lahir)
                        {{ \Carbon\Carbon::parse($s->tgl_lahir)->age }} th
                        @else
                        <span class="text-red-500 italic text-xs">Belum diisi</span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    @if(auth()->user()->isAdmin())
                    <td class="px-3 py-2 text-center">
                        <div class="flex justify-center gap-2">

                            {{-- Edit --}}
                            <button x-show="!editing"
                                @click="editing=true"
                                class="inline-flex items-center justify-center px-3 py-1 rounded-xl
            bg-slate-400 text-white text-xs font-extralight hover:bg-slate-800 transition shadow-sm">
                                Edit
                            </button>

                        </div>
                    </td>
                    @endif

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-3 py-6 text-center text-slate-500 font-extralight">
                        Data tidak ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>

</div>

{{-- Alpine.js CDN --}}
<script src="//unpkg.com/alpinejs" defer></script>
@endsection