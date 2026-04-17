@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Form Orang Tua</h2>

    @if(session('success'))
    <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <form action="{{ route('pendaftaran-santri.storeOrangtua') }}" method="POST">
        @csrf

        <!-- Pilih Santri -->
        <div class="mb-4">
            <label class="block font-medium mb-1">Santri</label>
            <select name="santri_id" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-sky-400">
                <option value="">-- Pilih Santri --</option>
                @foreach(\App\Models\Santri::all() as $santri)
                <option value="{{ $santri->id }}">{{ $santri->nama }}</option>
                @endforeach
            </select>
            @error('santri_id')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <!-- Nama Ayah -->
        <div class="mb-4">
            <label class="block font-medium mb-1">Nama Ayah</label>
            <input type="text" name="nama_ayah" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-sky-400">
            @error('nama_ayah')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <!-- Nama Ibu -->
        <div class="mb-4">
            <label class="block font-medium mb-1">Nama Ibu</label>
            <input type="text" name="nama_ibu" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-sky-400">
            @error('nama_ibu')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <!-- Status Orang Tua -->
        <div class="mb-4">
            <label class="block font-medium mb-1">Status Orang Tua</label>
            <select name="status_orangtua" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-sky-400">
                <option value="">-- Pilih Status --</option>
                @foreach($statusOptions as $status)
                <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
            </select>
            @error('status_orangtua')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <!-- Pekerjaan Ayah -->
        <div class="mb-4">
            <label class="block font-medium mb-1">Pekerjaan Ayah</label>
            <input type="text" name="pekerjaan_ayah" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-sky-400">
        </div>

        <!-- Pekerjaan Ibu -->
        <div class="mb-4">
            <label class="block font-medium mb-1">Pekerjaan Ibu</label>
            <input type="text" name="pekerjaan_ibu" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-sky-400">
        </div>

        <!-- No. Kontak -->
        <div class="mb-4">
            <label class="block font-medium mb-1">No. Kontak</label>
            <input type="text" name="no_kontak" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-sky-400">
        </div>

        <!-- Alamat -->
        <div class="mb-6">
            <label class="block font-medium mb-1">Alamat</label>
            <textarea name="alamat" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-sky-400"></textarea>
        </div>

        <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Simpan</button>
    </form>
</div>
@endsection