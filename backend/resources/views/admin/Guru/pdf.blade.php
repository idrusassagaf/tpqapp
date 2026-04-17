@extends('layouts.pdf-master')

@section('title', 'Laporan Data Guru')

@section('content')

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="30%">Nama Guru</th>
            <th width="15%">NIG</th>
            <th width="15%">Jenis Kelamin</th>
            <th width="20%">Mapel</th>
        </tr>
    </thead>
    <tbody>
        @foreach($gurus as $i => $g)
        <tr>
            <td align="center">{{ $i + 1 }}</td>
            <td>{{ $g->nama }}</td>
            <td align="center">{{ $g->nig ?? '-' }}</td>
            <td align="center">{{ $g->jenis_kelamin ?? '-' }}</td>
            <td align="center">{{ $g->mapel ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>


@endsection