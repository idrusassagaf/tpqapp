@extends('layouts.app')

@section('content')
<h1 class="text-lg font-medium mb-4">Edit Orang Tua</h1>

<form action="{{ route('orangtua.update', $orangtua->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="mb-4">
        <label class="block mb-1">Nama Ayah</label>
        <input type="text" name="nama_ayah"
            value="{{ old('nama_ayah', $orangtua->nama_ayah) }}"
            class="w-full border rounded px-3 py-2">
    </div>

    <div class="mb-4">
        <label class="block mb-1">Nama Ibu</label>
        <input type="text" name="nama_ibu"
            value="{{ old('nama_ibu', $orangtua->nama_ibu) }}"
            class="w-full border rounded px-3 py-2">
    </div>

    <div class="mb-4">
        <label class="block mb-1">Status Orang Tua</label>
        <select name="status_orangtua"
            class="w-full border rounded px-3 py-2" required>
            @foreach ($statusList as $status)
            <option value="{{ $status }}"
                {{ $orangtua->status_orangtua == $status ? 'selected' : '' }}>
                {{ $status }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="flex gap-2">
        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Update
        </button>
        <a href="{{ route('orangtua.index') }}"
            class="px-4 py-2 border rounded">
            Kembali
        </a>
    </div>
</form>
@endsection