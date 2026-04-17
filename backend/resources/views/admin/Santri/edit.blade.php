@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-8">

    <h2 class="text-2xl font-extralight text-gray-700 mb-4">Edit Santri</h2>

    @if(session('success'))
    <div class="mb-3 px-3 py-2 bg-green-100 text-green-700 rounded text-sm">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('santri.update', $santri->id) }}" method="POST" enctype="multipart/form-data"
        class="bg-white p-6 rounded shadow space-y-4 text-sm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium text-gray-600 mb-1">Nama Santri</label>
                <input type="text" name="nama" value="{{ old('nama', $santri->nama) }}"
                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-green-400 @error('nama') border-red-500 @enderror">
                @error('nama')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium text-gray-600 mb-1">NIS</label>
                <input type="text" name="nis" value="{{ old('nis', $santri->nis) }}"
                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-green-400 @error('nis') border-red-500 @enderror">
                @error('nis')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium text-gray-600 mb-1">Jenis Kelamin</label>
                <select name="jk">
                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-green-400 @error('jenis_kelamin') border-red-500 @enderror">
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jk', $santri->jk) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jk', $santri->jk) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium text-gray-600 mb-1">Kelas</label>
                <select name="kelas"
                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-green-400 @error('kelas') border-red-500 @enderror">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelasList as $kelas)
                    <option value="{{ $kelas }}" {{ old('kelas', $santri->kelas) == $kelas ? 'selected' : '' }}>
                        {{ $kelas }}
                    </option>
                    @endforeach
                </select>
                @error('kelas')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block font-medium text-gray-600 mb-1">Foto Santri</label>
                <input type="file" name="foto" id="fotoInput"
                    class="w-full border rounded px-2 py-1 @error('foto') border-red-500 @enderror">
                @error('foto')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <!-- Preview Foto Lama / Baru -->
                <div class="mt-2">
                    <img id="fotoPreview" src="{{ $santri->foto ? asset('storage/'.$santri->foto) : asset('images/default.png') }}"
                        alt="Preview Foto"
                        class="w-32 h-32 rounded-full object-cover border-2 border-gray-300">
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-2 mt-4">
            <a href="{{ route('santri.index') }}"
                class="px-3 py-1 bg-gray-200 text-black rounded hover:bg-gray-100 transition text-sm">
                Batal
            </a>
            <button type="submit"
                class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition text-sm">
                Simpan
            </button>
        </div>
    </form>
</div>

{{-- Script preview foto --}}
<script>
    const fotoInput = document.getElementById('fotoInput');
    const fotoPreview = document.getElementById('fotoPreview');

    fotoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                fotoPreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            fotoPreview.src = "{{ $santri->foto ? asset('storage/'.$santri->foto) : asset('images/default.png') }}";
        }
    });
</script>
@endsection