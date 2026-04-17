@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-6">

    <h2 class="text-2xl font-extralight text-gray-700 mb-4">
        Tambah Santri
    </h2>

    <form action="{{ route('santri.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white p-6 rounded shadow text-sm">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- NAMA -->
            <div>
                <label class="text-gray-600">Nama</label>
                <input type="text" name="nama" value="{{ old('nama') }}"
                       class="w-full border rounded px-2 py-1 @error('nama') border-red-500 @enderror">
                @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- NIS OTOMATIS -->
            <div>
                <label class="text-gray-600">NIS</label>
                <input type="text" name="nis"
                       value="{{ $nis }}"
                       readonly
                       class="w-full border bg-gray-100 rounded px-2 py-1 cursor-not-allowed">
            </div>

            <!-- JENIS KELAMIN -->
            <div>
                <label class="text-gray-600">Jenis Kelamin</label>
                <select name="jenis_kelamin"
                        class="w-full border rounded px-2 py-1 @error('jenis_kelamin') border-red-500 @enderror">
                    <option value="">Pilih</option>
                    <option value="L" {{ old('jenis_kelamin')=='L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin')=='P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- KELAS (DROPDOWN) -->
            <div>
                <label class="text-gray-600">Kelas</label>
                <select name="kelas"
                        class="w-full border rounded px-2 py-1 @error('kelas') border-red-500 @enderror">
                    <option value="">Pilih Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas }}" {{ old('kelas') == $kelas ? 'selected' : '' }}>
                            {{ $kelas }}
                        </option>
                    @endforeach
                </select>
                @error('kelas')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- FOTO -->
            <div class="md:col-span-2">
                <label class="text-gray-600">Foto Santri</label>
                <input type="file" name="foto" id="fotoInput"
                       class="w-full border rounded px-2 py-1 @error('foto') border-red-500 @enderror">
                @error('foto')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <div class="mt-2">
                    <img id="fotoPreview"
                         src="{{ asset('images/default.png') }}"
                         class="w-32 h-32 rounded-full object-cover border">
                </div>
            </div>

        </div>

        <!-- BUTTON -->
        <div class="mt-4 flex gap-2">
            <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Simpan
            </button>
            <a href="{{ route('santri.index') }}"
               class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
document.getElementById('fotoInput').addEventListener('change', function(){
    const file = this.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = e => document.getElementById('fotoPreview').src = e.target.result;
    reader.readAsDataURL(file);
});
</script>
@endsection
