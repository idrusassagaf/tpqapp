@extends('layouts.pdf-master')
@section('title', 'Laporan Status Santri')
@section('content')

<table>
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th style="width:35%;" class="text-left">Nama Santri</th>
            <th style="width:20%;">NIS</th>
            <th style="width:40%;">Status Santri</th>
        </tr>
    </thead>
    <tbody>
        @foreach($santris as $index => $santri)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td class="text-left">{{ $santri->nama }}</td>
            <td>{{ $santri->nis ?? '-' }}</td>
            <td>{{ $santri->status_santri ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection