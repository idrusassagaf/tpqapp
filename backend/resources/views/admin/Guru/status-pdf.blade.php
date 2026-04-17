@extends('layouts.pdf-master')

@section('content')

<table>
    <thead>
        <tr>
            <th>Nama Guru</th>
            <th>NIG</th>
            <th>Kehadiran</th>
            <th>Status Guru</th>
        </tr>
    </thead>
    <tbody>
        @foreach($gurus as $g)
        <tr>
            <td class="text-left">{{ $g->nama }}</td>
            <td>{{ $g->nig }}</td>
            <td>{{ $g->kehadiran ?? '-' }}</td>
            <td>{{ $g->status_guru ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection