@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-8">

    <h2 class="text-2xl font-extralight text-gray-700 mb-4">Edit Guru</h2>

    <form action="{{ route('guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data"
          class="bg-white p-4 rounded-lg shadow space-y-3 text-sm">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium text-gray-600 mb-1">Nama Guru</label>
            <input type="text" name="nama" value="{{ old('nama', $guru->nama) }}"
                   class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        <div>
            <label class="block font-medium text-gray-600 mb-1">NIG</label>
            <input type="text" name="nig" value="{{ $guru->nig }}" readonly
                   class="w-full border rounded px-2 py-1 bg-gray-100 cursor-not-allowed">
        </div>

        <div>
            <label class="block font-medium text-gray-600 mb-1">Jenis Kelamin</label>
            <select name="jenis_kelamin"
                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                <option value="L" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div>
            <label class="block font-medium text-gray-600 mb-1">Mapel</label>
            <select name="mapel"
                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                <option value="">-- Pilih Mapel --</option>
                @foreach ($mapelList as $mapel)
                    <option value="{{ $mapel }}" {{ old('mapel', $guru->mapel) == $mapel ? 'selected' : '' }}>
                        {{ $mapel }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium text-gray-600 mb-1">Foto</label>
            <input type="file" name="foto" accept="image/*"
                   class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-green-400">
            @if($guru->foto && file_exists(storage_path('app/public/'.$guru->foto)))
                <img src="{{ asset('storage/'.$guru->foto) }}" alt="Foto Guru"
                     class="w-32 h-32 rounded-full object-cover mt-2 border-2 border-blue-300 shadow-md">
            @endif
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('guru.index') }}" class="px-3 py-1 bg-gray-200 text-black rounded hover:bg-gray-100 transition text-sm">
                Batal
            </a>
            <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition text-sm">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
