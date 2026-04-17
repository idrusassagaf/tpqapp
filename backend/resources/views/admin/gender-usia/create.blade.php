@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-lg">

    <h1 class="text-xl font-bold mb-4">Tambah Data Gender & Usia</h1>

    <form method="POST" action="{{ route('gender-usia.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm mb-1">Nama Santri</label>
            <select name="santri_id" class="border rounded px-3 py-2 w-full">
                <option value="">-- Pilih Santri --</option>
                @foreach ($santri as $s)
                <option value="{{ $s->id }}">
                    {{ $s->nama }} ({{ $s->jenis_kelamin }})
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1">Tanggal Lahir</label>
            <input type="date" name="tgl_lahir" class="border rounded px-3 py-2 w-full">
        </div>

        <div class="flex gap-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('gender-usia.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
        </div>

    </form>
</div>
@endsection