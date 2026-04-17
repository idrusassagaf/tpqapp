@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-6">

    <div class="flex items-center justify-between gap-4 mb-5">
        <div>
            <h1 class="text-2xl font-extralight tracking-wide text-slate-800">
                Edit Berita
            </h1>
            <p class="text-sm text-slate-500 font-extralight mt-1">
                Perbarui judul, konten, status, gambar.
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

    <form method="POST" action="{{ route('berita.update', $berita->id) }}" enctype="multipart/form-data"
        class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        @csrf
        @method('PUT')

        <div class="p-6 space-y-4">

            <div>
                <label class="block text-sm text-slate-600 font-extralight mb-1">Judul</label>
                <input type="text" name="judul" value="{{ old('judul', $berita->judul) }}"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                    focus:outline-none focus:ring-2 focus:ring-sky-200 focus:border-sky-300" required>
            </div>

            <div>
                <label class="block text-sm text-slate-600 font-extralight mb-1">Isi Berita</label>
                <textarea name="isi" rows="8"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                    focus:outline-none focus:ring-2 focus:ring-sky-200 focus:border-sky-300"
                    required>{{ old('isi', $berita->isi) }}</textarea>
            </div>

            <div>
                <label class="block text-sm text-slate-600 font-extralight mb-1">Gambar</label>

                <!-- Preview gambar lama / default -->
                @if($berita->gambar)
                <img id="previewImg" src="{{ asset('storage/'.$berita->gambar) }}"
                    class="w-28 h-28 rounded-2xl object-cover border border-slate-200 mb-2">
                @else
                <img id="previewImg" src="#" class="w-28 h-28 rounded-2xl object-cover border border-slate-200 mb-2 hidden">
                @endif

                <input type="file" name="gambar" id="gambarInput"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white">
            </div>

            <div>
                <label class="block text-sm text-slate-600 font-extralight mb-1">Status</label>
                <select name="status"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm bg-white
                    focus:outline-none focus:ring-2 focus:ring-sky-200 focus:border-sky-300">
                    <option value="Draft" {{ old('status', $berita->status)=='Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Publish" {{ old('status', $berita->status)=='Publish' ? 'selected' : '' }}>Publish</option>
                </select>
            </div>

        </div>

        <div class="px-6 py-4 border-t border-slate-200 flex justify-end">
            <button type="submit"
                class="px-6 py-2 rounded-xl bg-slate-800 text-white text-sm font-extralight hover:bg-slate-900 transition shadow-sm">
                Update
            </button>
        </div>
    </form>
</div>

<!-- Script preview gambar -->
<script>
    const input = document.getElementById('gambarInput');
    const preview = document.getElementById('previewImg');

    input.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.setAttribute('src', e.target.result);
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection