@extends('layouts.pdf-master')

@section('content')

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="25%">Nama</th>
            <th width="20%">NIG</th>
            <th width="30%">Alamat</th>
            <th width="20%">No. Kontak</th>
        </tr>
    </thead>
    <tbody>
        @foreach($gurus as $index => $guru)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td class="text-left">{{ $guru->nama }}</td>
            <td>{{ $guru->nig }}</td>
            <td class="text-left">{{ $guru->alamat }}</td>
            <td>{{ $guru->no_kontak }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection