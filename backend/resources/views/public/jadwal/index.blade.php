@extends('public.layouts.app')

@section('content')


<!-- HEADER -->
<div class="max-w-6xl mx-auto px-4 py-8 text-center md:text-left">

    <!-- JUDUL -->
    <h1 class="text-xl md:text-2xl font-semibold mb-4 text-white">
        Kalender Pengajian Santri TPQ
    </h1>

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

        <!-- BULAN / TAHUN -->
        <div class="flex items-center gap-3 justify-center md:justify-start">

            <a href="?bulan={{ $bulan-1 <= 0 ? 12 : $bulan-1 }}&tahun={{ $bulan-1 <= 0 ? $tahun-1 : $tahun }}"
                class="px-3 py-1 bg-white/20 rounded hover:bg-white/30">←</a>

            <h2 class="text-lg md:text-xl font-semibold">
                {{ \Carbon\Carbon::create($tahun, $bulan)->translatedFormat('F Y') }}
            </h2>

            <a href="?bulan={{ $bulan+1 > 12 ? 1 : $bulan+1 }}&tahun={{ $bulan+1 > 12 ? $tahun+1 : $tahun }}"
                class="px-3 py-1 bg-white/20 rounded hover:bg-white/30">→</a>

        </div>

        <!-- LEGEND -->
        <div class="flex justify-center md:justify-end gap-4 text-xs md:text-sm text-blue-100">

            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-green-400"></span>
                Mengaji
            </div>

            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-red-400"></span>
                Libur
            </div>

        </div>

    </div>

</div>

<!-- CALENDAR -->
<div class="max-w-6xl mx-auto px-4 pb-16">

    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 shadow-lg">

        <div class="grid grid-cols-7 gap-2 text-center">

            <!-- HARI -->
            @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $hari)
            <div class="font-semibold text-blue-200 text-xs md:text-sm">
                {{ $hari }}
            </div>
            @endforeach

            @php
            $start = \Carbon\Carbon::create($tahun, $bulan)->startOfMonth()->startOfWeek();
            $end = \Carbon\Carbon::create($tahun, $bulan)->endOfMonth()->endOfWeek();
            @endphp

            @while($start <= $end)

                @php
                $jadwalHari=$jadwals->firstWhere('tanggal', $start->toDateString());
                $isToday = $start->toDateString() == now()->toDateString();
                $isCurrentMonth = $start->month == $bulan;
                @endphp

                <div class="p-2 rounded-lg h-[60px] md:h-[75px]
                        {{ $isToday ? 'bg-yellow-400/20 border border-yellow-300' : 'bg-white/5' }}
                        {{ !$isCurrentMonth ? 'opacity-40' : '' }}">

                    <!-- TANGGAL -->
                    <div class="text-xs mb-1">
                        {{ $start->format('d') }}
                    </div>

                    <!-- STATUS -->
                    @if($jadwalHari)
                    @if($jadwalHari->status == 'mengaji')
                    <div class="w-2.5 h-2.5 mx-auto rounded-full bg-green-400"></div>
                    @else
                    <div class="w-2.5 h-2.5 mx-auto rounded-full bg-red-400"></div>
                    @endif
                    @endif

                </div>

                @php $start->addDay(); @endphp

                @endwhile

        </div>

    </div>

</div>

</div>

@endsection