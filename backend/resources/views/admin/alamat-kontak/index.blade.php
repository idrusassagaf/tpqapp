@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Alamat & Kontak Santri</h1>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="table-auto w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-2 py-1">No</th>
                <th class="border px-2 py-1">Nama</th>
                <th class="border px-2 py-1">Alamat</th>
                <th class="border px-2 py-1">Kontak</th>
                <th class="border px-2 py-1">Aksi</th>
            </tr>
        </thead>

        <tbody>
          @foreach($santris as $index => $santri)
<tr>
    <td class="border px-2 py-1 text-black bg-white">{{ $index + 1 }}</td>
    <td class="border px-2 py-1 text-black bg-white">{{ $santri->nama }}</td>
    <td class="border px-2 py-1 text-black bg-white">{{ $santri->alamat }}</td>
    <td class="border px-2 py-1 text-black bg-white">{{ $santri->no_kontak }}</td>
    <td class="border px-2 py-1 text-black bg-white">-</td>
    
</tr>
@endforeach


        </tbody>
    </table>
</div>
@endsection
