@extends('layouts.pdf-master')

@section('content')

<table class="table">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="40%">Nama</th>
            <th width="25%">NIG</th>
            <th width="30%">Pendidikan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($gurus as $index => $guru)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $guru->nama }}</td>
            <td>{{ $guru->nig }}</td>
            <td>{{ $guru->pendidikan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection