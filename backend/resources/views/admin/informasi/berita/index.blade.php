@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between gap-4 mb-4">
        <div>
            <h1 class="text-2xl font-extralight tracking-wide text-slate-800">
                Data Berita
            </h1>
            <p class="text-sm text-slate-500 font-extralight mt-1">
                Kelola berita TPQ (tambah, edit, hapus, publish).
            </p>
        </div>

        <a href="{{ route('berita.create') }}"
            class="px-4 py-2 rounded-xl bg-slate-800 text-white text-sm font-extralight hover:bg-slate-900 transition shadow-sm">
            + Tambah Berita
        </a>
    </div>

    {{-- SEARCH --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-4 p-4">
        <form method="GET" action="{{ route('berita.index') }}">
            <div class="flex gap-3">
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Cari judul berita..."
                    class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm
                    focus:outline-none focus:ring-2 focus:ring-sky-200">

                <button type="submit"
                    class="px-4 py-2 rounded-xl bg-slate-700 text-white text-sm hover:bg-slate-800 transition">
                    Cari
                </button>

                <a href="{{ route('berita.index') }}"
                    class="px-4 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700 text-sm">
        {{ session('success') }}
    </div>
    @endif

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-200 text-slate-600">
                    <tr>
                        <th class="px-3 py-2 text-center w-[50px]">No</th>
                        <th class="px-3 py-2 w-[120px] text-center">Gambar</th>
                        <th class="px-3 py-2">Judul</th>
                        <th class="px-3 py-2 w-[120px] text-center">Status</th>
                        <th class="px-3 py-2 w-[120px] text-center">Views</th>
                        <th class="px-3 py-2 w-[160px] text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($beritas as $i => $b)
                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-3 py-2 text-center">
                            {{ ($beritas->currentPage()-1)*$beritas->perPage()+$i+1 }}
                        </td>

                        {{-- GAMBAR --}}
                        <td class="px-3 py-2 text-center">
                            @if($b->gambar)
                            <img src="{{ asset('storage/'.$b->gambar) }}"
                                class="w-16 h-16 object-cover rounded-lg border mx-auto">
                            @else
                            <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center text-xs text-slate-400 mx-auto">
                                No Img
                            </div>
                            @endif
                        </td>

                        {{-- JUDUL --}}
                        <td class="px-3 py-2">
                            <div class="font-medium text-slate-800">
                                {{ $b->judul }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ Str::limit($b->isi, 60) }}
                            </div>
                        </td>

                        {{-- STATUS --}}
                        <td class="px-3 py-2 text-center">
                            @if($b->status == 'Publish')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                Publish
                            </span>
                            @else
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                Draft
                            </span>
                            @endif
                        </td>

                        {{-- VIEWS --}}
                        <td class="px-3 py-2 text-center text-slate-600">
                            {{ $b->views ?? 0 }}
                        </td>

                        {{-- AKSI --}}
                        <td class="px-3 py-2 text-center">
                            <div class="flex justify-center gap-2">

                                <a href="{{ route('berita.edit', $b->id) }}"
                                    class="px-3 py-1 rounded-lg bg-blue-500 text-white text-xs hover:bg-blue-600">
                                    Edit
                                </a>

                                <form action="{{ route('berita.destroy', $b->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin hapus berita ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="px-3 py-1 rounded-lg bg-red-500 text-white text-xs hover:bg-red-600">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-slate-500">
                            Belum ada data berita
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $beritas->links() }}
    </div>

</div>
@endsection