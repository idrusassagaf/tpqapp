@extends('layouts.pdf-master')

@section('title', 'Laporan Data Kelahiran & Usia Guru')

@section('content')

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Guru</th>
            <th>JK</th>
            <th>Tanggal Lahir</th>
            <th>Usia</th>
        </tr>
    </thead>
    <tbody>
        @foreach($gurus as $g)
        <tr>
            <td>{{ $g->nama }}</td>
            <td>{{ $g->jenis_kelamin ?? '-' }}</td>
            <td>
                @if($g->tgl_lahir)
                {{ \Carbon\Carbon::parse($g->tgl_lahir)->format('d-m-Y') }}
                @else
                -
                @endif
            </td>
            <td>
                @if($g->tgl_lahir)
                {{ \Carbon\Carbon::parse($g->tgl_lahir)->age }} th
                @else
                -
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection