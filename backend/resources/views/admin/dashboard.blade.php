@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-1 px-4 bg-slate-0 rounded-2xl py-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-2">
        <div>
            <h1 class="text-2xl font-medium tracking-wide text-slate-800">
                Dashboard
            </h1>
            <p class="text-sm text-slate-900 font-extralight mt-1">
                Ringkasan data terbaru dan akses cepat ke fitur utama TPQ
            </p>
        </div>

        {{-- Info kanan --}}
        <div class="bg-slate-100 rounded-2xl border border-slate-400 shadow-sm px-3 py-1 text-sm">
            <div class="text-slate-900 font-light">
                Hari ini :
                <span class="text-slate-800 font-medium">
                    {{ now()->format('d M Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        {{-- SANTRI --}}
        <div class="bg-lime-800 rounded-2xl border border-blue-100 shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-white font-medium">Total Santri</div>
                    <div class="text-2xl text-white font-light mt-1">
                        {{ $totalSantri ?? 0 }}
                    </div>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-gray-300 flex items-center justify-center ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3zm0 2c-3.314 0-6 1.343-6 3v2h12v-2c0-1.657-2.686-3-6-3z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-xs text-white font-extralight">
                Santri yang terdata di sistem
            </div>
        </div>

        {{-- GURU --}}
        <div class="bg-blue-800 rounded-2xl border border-red-100 shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-white font-medium">Total Guru</div>
                    <div class="text-2xl text-white font-light mt-1">
                        {{ $totalGuru ?? 0 }}
                    </div>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-green-500 flex items-center justify-center ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M16 11c1.657 0 3-1.343 3-3S17.657 5 16 5s-3 1.343-3 3 1.343 3 3 3zm0 2c-2.761 0-5 1.12-5 2.5V18h10v-2.5c0-1.38-2.239-2.5-5-2.5zM8 11c1.657 0 3-1.343 3-3S9.657 5 8 5 5 6.343 5 8s1.343 3 3 3zm0 2c-2.761 0-5 1.12-5 2.5V18h8v-2.5C11 14.12 10.761 13 8 13z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-xs text-white font-extralight">
                Guru yang terdata di sistem
            </div>
        </div>

        {{-- ORANGTUA --}}
        <div class="bg-yellow-800 rounded-2xl border border-green-500 shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-white font-medium">Data Orang Tua</div>
                    <div class="text-2xl text-white font-light mt-1">
                        {{ $totalOrangtua ?? 0 }}
                    </div>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-400 flex items-center justify-center border border-yellow-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 19c0-1.657-1.79-3-4-3s-4 1.343-4 3m8-10a4 4 0 11-8 0 4 4 0 018 0zm6 10v-1c0-1.1-1.12-2.07-2.7-2.6" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-xs text-white font-extralight">
                Orang Tua yang terdata di sistem
            </div>
        </div>

        {{-- BERITA --}}
        <div class="bg-red-800 rounded-2xl border border-red-800 shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-white font-medium">Informasi </div>
                    <div class="text-2xl text-white font-light mt-1">
                        {{ $totalBerita ?? 0 }}
                    </div>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-yellow-500 flex items-center justify-center border border-yellow-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 7H5m14 0v14H5V7m14 0l-2-2H7L5 7m4 4h6m-6 4h10" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-xs text-white font-extralight">
                Berita dan Pengumuman
            </div>
        </div>

    </div>

    {{-- GRID BAWAH --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- AKSES CEPAT --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
            <h3 class="text-base font-medium text-slate-800 mb-3">
                Akses Cepat
            </h3>

            <div class="grid grid-cols-2 gap-2 text-sm">
                <a href="{{ route('santri.index') }}"
                    class="px-3 py-2 rounded-xl border border-slate-200 bg-slate-100 hover:bg-slate-300 transition text-slate-700 font-extralight text-center">
                    Data Santri
                </a>

                <a href="{{ url('/guru') }}"
                    class="px-3 py-2 rounded-xl border border-slate-200 bg-slate-100 hover:bg-slate-300 transition text-slate-700 font-extralight text-center">
                    Data Guru
                </a>

                <a href="{{ url('/orangtua') }}"
                    class="px-3 py-2 rounded-xl border border-slate-200 bg-slate-100 hover:bg-slate-300 transition text-slate-700 font-extralight text-center">
                    Orang Tua
                </a>

                <a href="{{ route('berita.index') }}"
                    class="px-3 py-2 rounded-xl border border-slate-200 bg-slate-100 hover:bg-slate-300 transition text-slate-700 font-extralight text-center">
                    Berita
                </a>

                <a href="{{ route('status.index') }}"
                    class="px-3 py-2 rounded-xl border border-slate-200 bg-slate-100 hover:bg-slate-300 transition text-slate-700 font-extralight text-center">
                    Status Sosial
                </a>

                <a href="{{ route('gender-usia.index') }}"
                    class="px-3 py-2 rounded-xl border border-slate-200 bg-slate-100 hover:bg-slate-300 transition text-slate-700 font-extralight text-center">
                    Gender & Usia
                </a>

                {{-- tombol tambahan --}}
                <a href="{{ url('/pendaftaran-santri') }}"
                    class="px-3 py-2 rounded-xl border border-slate-200 bg-slate-100 hover:bg-slate-300 transition text-slate-700 font-extralight text-center">
                    Pendaftaran-S
                </a>

                <a href="{{ url('/pendaftaran-guru') }}"
                    class="px-3 py-2 rounded-xl border border-slate-200 bg-slate-100 hover:bg-slate-300 transition text-slate-700 font-extralight text-center">
                    Pendaftaran-G
                </a>

                <a href="{{ url('/orangtua') }}"
                    class="px-3 py-2 rounded-xl border border-slate-200 bg-slate-100 hover:bg-slate-300 transition text-slate-700 font-extralight text-center">
                    Status OT
                </a>

                <a href="{{ url('/guru/status') }}"
                    class="px-3 py-2 rounded-xl border border-slate-200 bg-slate-100 hover:bg-slate-300 transition text-slate-700 font-extralight text-center">
                    St. Kehadiran-G
                </a>
            </div>
        </div>

        {{-- SANTRI TERBARU --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 lg:col-span-2">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-base font-medium text-slate-800">
                    Santri Terbaru
                </h3>

                <a href="{{ route('santri.index') }}"
                    class="text-xs text-slate-900 hover:text-slate-900 font-medium">
                    Lihat semua →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-xs">
                    <thead class="bg-slate-200 text-slate-600">
                        <tr>
                            <th class="px-3 py-2 text-center w-[110px]">Nama - NIS</th>
                            <th class="px-3 py-2 text-center w-[30px]">Usia</th>
                            <th class="px-3 py-2 text-center w-[135px]">Orang Tua</th>
                            <th class="px-3 py-2 text-right w-[100px]">Dibuat</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse($santriTerbaru ?? [] as $s)
                        <tr class="hover:bg-slate-50 transition">

                            {{-- Nama/NIS --}}
                            <td class="px-3 py-2 text-slate-800 font-extralight">
                                {{ $s->nama }}
                                <div class="text-[10px] text-slate-500 mt-0.5">
                                    NIS: {{ $s->nis ?? '-' }}
                                </div>
                            </td>

                            {{-- Usia --}}
                            <td class="px-3 py-2 text-center text-slate-700 font-extralight">
                                <span class="px-2 py-0.5 rounded-lg border border-slate-200 bg-white">
                                    {{ $s->usia ?? '-' }}
                                </span>
                            </td>

                            {{-- Nama Orang Tua --}}
                            <td class="px-3 py-2 text-slate-700 font-extralight">
                                @if($s->orangtua)
                                {{ $s->orangtua->nama_ayah ?? '-' }} & {{ $s->orangtua->nama_ibu ?? '-' }}
                                @else
                                -
                                @endif

                            </td>

                            {{-- Dibuat --}}
                            <td class="px-3 py-2 text-right text-slate-500 font-extralight">
                                {{ $s->created_at?->format('d-m-Y') }}
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-3 py-6 text-center text-slate-500 font-extralight">
                                Belum ada data santri.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

    </div>

</div>
@endsection