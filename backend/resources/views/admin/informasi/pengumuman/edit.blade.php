@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-6">

    <div class="flex items-start justify-between gap-4 mb-5">
        <div>
            <h1 class="text-2xl font-extralight tracking-wide text-slate-800">
                Edit Pengumuman
            </h1>
            <p class="text-sm text-slate-500 font-extralight mt-1">
                Perbarui data pengumuman.
            </p>
        </div>

        <a href="{{ route('pengumuman.index') }}"
            class="rounded-xl border border-slate-200 bg-white text-slate-700 px-4 py-2 text-sm font-extralight hover:bg-slate-50 transition">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden p-6">

        <form method="POST" action="{{ route('pengumuman.update', $pengumuman->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="text-sm text-slate-600 font-extralight">Judul</label>
                <input type="text" name="judul" value="{{ $pengumuman->judul }}" required
                    class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                    focus:outline-none focus:ring-2 focus:ring-sky-200" />
            </div>

            <div>
                <label class="text-sm text-slate-600 font-extralight">Tanggal</label>
                <input type="date" name="tanggal" value="{{ $pengumuman->tanggal }}"
                    class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                    focus:outline-none focus:ring-2 focus:ring-sky-200" />
            </div>

            <div>
                <label class="text-sm text-slate-600 font-extralight">Isi</label>
                <textarea name="isi" rows="4" required
                    class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                    focus:outline-none focus:ring-2 focus:ring-sky-200">{{ $pengumuman->isi }}</textarea>
            </div>

            <div>
                <label class="text-sm text-slate-600 font-extralight">Status</label>
                <select name="status"
                    class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                    focus:outline-none focus:ring-2 focus:ring-sky-200">
                    <option value="Aktif" {{ $pengumuman->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Nonaktif" {{ $pengumuman->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <button type="submit"
                class="rounded-xl bg-slate-800 text-white px-4 py-2 text-sm font-extralight hover:bg-slate-900 transition">
                Update
            </button>

        </form>

    </div>
</div>
@endsection