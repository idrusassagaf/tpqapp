@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-6">

    <div class="flex items-center justify-between gap-4 mb-5">
        <div>
            <h1 class="text-2xl font-extralight tracking-wide text-slate-800">
                Tambah Berita
            </h1>
            <p class="text-sm text-slate-500 font-extralight mt-1">
                Isi judul, konten, gambar (opsional).
            </p>
        </div>

        <a href="{{ route('berita.index') }}"
            class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-700 text-sm font-extralight hover:bg-slate-50 transition">
            Kembali
        </a>
    </div>

    @if($errors->any())
    <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-700 text-sm font-extralight">
        <ul class="list-disc ml-5">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('berita.store') }}" enctype="multipart/form-data"
        class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        @csrf

        <div class="p-6 space-y-4">

            <div>
                <label class="block text-sm text-slate-600 font-extralight mb-1">Judul</label>
                <input type="text" name="judul" value="{{ old('judul') }}"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                    focus:outline-none focus:ring-2 focus:ring-sky-200 focus:border-sky-300" required>
            </div>

            <div>
                <label class="block text-sm text-slate-600 font-extralight mb-1">Isi Berita</label>
                <textarea name="isi" rows="8"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                    focus:outline-none focus:ring-2 focus:ring-sky-200 focus:border-sky-300"
                    required>{{ old('isi') }}</textarea>
            </div>

            <div>
                <label class="block text-sm text-slate-600 font-extralight mb-1">Gambar (Opsional)</label>
                <input type="file" name="gambar"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white">
            </div>

            <div>
                <label class="block text-sm text-slate-600 font-extralight mb-1">Status</label>
                <select name="status"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                    focus:outline-none focus:ring-2 focus:ring-sky-200 focus:border-sky-300">
                    <option value="Draft" {{ old('status')=='Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Publish" {{ old('status')=='Publish' ? 'selected' : '' }}>Publish</option>
                </select>
            </div>

        </div>

        <div class="px-6 py-4 border-t border-slate-200 flex justify-end">
            <button type="submit"
                class="px-6 py-2 rounded-xl bg-slate-800 text-white text-sm font-extralight hover:bg-slate-900 transition shadow-sm">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection