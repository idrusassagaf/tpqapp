@extends('layouts.pdf-master')

@section('content')

<table>
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th style="width:35%;" class="text-left">Nama</th>
            <th style="width:15%;">JK</th>
            <th style="width:20%;">Tgl Lahir</th>
            <th style="width:15%;">Usia</th>
        </tr>
    </thead>
    <tbody>
        @foreach($santris as $index => $santri)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td class="text-left">{{ $santri->nama }}</td>
            <td>{{ $santri->jk ?? '-' }}</td>
            <td>
                {{ $santri->tgl_lahir 
                    ? \Carbon\Carbon::parse($santri->tgl_lahir)->translatedFormat('d F Y') 
                    : '-' 
                }}
            </td>
            <td>
                {{ $santri->tgl_lahir 
                    ? \Carbon\Carbon::parse($santri->tgl_lahir)->age . ' th' 
                    : '-' 
                }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection