@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6">

    {{-- HEADER --}}
    <div class="flex items-start justify-between gap-4 mb-5">
        <div>
            <h1 class="text-2xl font-extralight tracking-wide text-slate-800">
                Informasi Pengumuman
            </h1>
            <p class="text-sm text-slate-500 font-extralight mt-1">
                Tambah, edit, dan hapus pengumuman untuk santri dan guru.
            </p>
        </div>

        @if(auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin')
        <a href="{{ route('pengumuman.create') }}"
            class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-slate-800 text-white text-sm font-extralight hover:bg-slate-900 transition shadow-sm">
            + Tambah
        </a>
        @endif
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        {{-- SEARCH --}}
        <div class="px-5 py-4 border-b border-slate-200">
            <form method="GET" action="{{ route('pengumuman.index') }}" class="flex gap-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari pengumuman..."
                    class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                    focus:outline-none focus:ring-2 focus:ring-sky-200" />

                <a href="{{ route('pengumuman.index') }}"
                    class="rounded-xl border border-slate-200 bg-white text-slate-700 px-4 py-2 text-sm font-extralight hover:bg-slate-50 transition">
                    Reset
                </a>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto w-full">
            <table class="min-w-full text-sm table-fixed">
                <thead class="bg-slate-200 text-slate-600">
                    <tr class="text-left">
                        <th class="px-4 py-3 w-[60px]">No</th>
                        <th class="px-4 py-3 w-[260px]">Judul</th>
                        <th class="px-4 py-3 w-[140px]">Tanggal</th>
                        <th class="px-4 py-3">Isi</th>
                        <th class="px-4 py-3 w-[140px]">Status</th>
                        @if(auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin')
                        <th class="px-4 py-3 w-[170px] text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($pengumuman as $i => $p)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="px-4 py-3 text-slate-500 font-extralight">{{ $i + 1 }}</td>

                        <td class="px-4 py-3 font-light text-slate-800">
                            {{ $p->judul }}
                        </td>

                        <td class="px-4 py-3 text-slate-600 font-extralight">
                            {{ $p->tanggal ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-slate-700 font-extralight">
                            {{ $p->isi }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-xs font-extralight
                                {{ $p->status == 'Aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $p->status }}
                            </span>
                        </td>

                        @if(auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin')
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-2">

                                <a href="{{ route('pengumuman.edit', $p->id) }}"
                                    class="px-4 py-2 rounded-xl bg-slate-400 text-white text-sm font-extralight hover:bg-slate-800 transition shadow-sm">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('pengumuman.destroy', $p->id) }}"
                                    onsubmit="return confirm('Yakin hapus pengumuman ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 rounded-xl border border-slate-300 bg-white text-slate-700 text-sm font-extralight hover:bg-slate-50 transition">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-slate-500 font-extralight">
                            Belum ada pengumuman.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection