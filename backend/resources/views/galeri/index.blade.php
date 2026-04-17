@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto mt-10">

    <!-- TITLE -->
    <h1 class="text-2xl font-semibold mb-6">Manajemen Galeri</h1>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
    <div class="bg-green-200 p-3 mb-4 rounded">
        {{ session('success') }}
    </div>
    @endif

    <!-- FORM UPLOAD -->
    <div class="bg-white shadow-md rounded-xl p-6 mb-8">
        <h2 class="font-semibold mb-3">Upload Foto</h2>

        <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="text" name="judul" placeholder="Judul"
                class="w-full border p-2 mb-3 rounded">

            <input type="file" name="foto"
                class="w-full border p-2 mb-3 rounded">

            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Upload
            </button>
        </form>
    </div>

    <!-- TABEL GALERI -->
    <div class="bg-white shadow-md rounded-xl p-6">
        <h2 class="font-semibold mb-4">Daftar Galeri</h2>

        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="text-left p-2">No</th>
                    <th class="text-left p-2">Foto</th>
                    <th class="text-left p-2">Judul</th>
                    <th class="text-left p-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($galeris as $index => $g)
                <tr class="border-b">
                    <td class="p-2">{{ $index + 1 }}</td>

                    <td class="p-2">
                        <img src="{{ asset('uploads/galeri/' . $g->foto) }}"
                            class="w-20 h-20 object-cover rounded">
                    </td>

                    <td class="p-2">
                        {{ $g->judul ?? '-' }}
                    </td>

                    <td class="p-2 flex gap-2">

                        <!-- EDIT -->
                        <a href="{{ route('galeri.edit', $g->id) }}"
                            class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                            Edit
                        </a>

                        <!-- HAPUS -->
                        <form action="{{ route('galeri.destroy', $g->id) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin hapus foto ini?')">
                            @csrf
                            @method('DELETE')

                            <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                Hapus
                            </button>
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center p-4 text-gray-500">
                        Belum ada data galeri
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

@endsection