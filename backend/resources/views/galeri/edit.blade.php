@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto mt-10">

    <h1 class="text-xl font-semibold mb-4">Edit Galeri</h1>

    @if(session('success'))
    <div class="bg-green-200 p-3 mb-3 rounded">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- JUDUL -->
        <input type="text" name="judul"
            value="{{ $galeri->judul }}"
            placeholder="Judul"
            class="w-full border p-2 mb-3 rounded">

        <!-- FOTO LAMA -->
        <div class="mb-3">
            <p class="text-sm text-gray-600 mb-1">Foto Saat Ini:</p>
            <img src="{{ asset('uploads/galeri/' . $galeri->foto) }}"
                class="w-32 rounded shadow">
        </div>

        <!-- FOTO BARU -->
        <input type="file" name="foto"
            class="w-full border p-2 mb-3 rounded">

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Update
        </button>

    </form>

</div>

@endsection