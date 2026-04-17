@extends('layouts.app')

@section('content')
<div class="text-center py-20 bg-gradient-to-r from-blue-100 to-blue-200 min-h-[80vh]">
    <h1 class="text-5xl font-bold mb-4">Selamat Datang di TPQ Khairunissa</h1>
    <p class="text-lg mb-6 max-w-xl mx-auto">
        Tempat pendidikan Al-Qur’an modern & lengkap, menampung santri dan guru profesional dengan fasilitas pembelajaran digital.
    </p>
    <div class="space-x-4">
        <a href="{{ route('login') }}"
           class="px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold">Login Admin</a>
        <a href="#about"
           class="px-6 py-3 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 font-semibold">Tentang TPQ</a>
    </div>
</div>

<section id="about" class="py-20 text-center">
    <h2 class="text-3xl font-semibold mb-4">Tentang TPQ Khairunissa</h2>
    <p class="max-w-2xl mx-auto">
        TPQ Khairunissa menampung Santri dan Guru profesional untuk pendidikan Al-Qur’an. 
        Kami menyediakan fasilitas pembelajaran modern dan sistem administrasi digital yang lengkap 
        untuk mendukung proses belajar yang efektif dan nyaman.
    </p>
</section>

<section class="py-20 bg-gray-50 text-center">
    <h2 class="text-3xl font-semibold mb-8">Statistik TPQ</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold">Total Santri</h3>
            <p class="text-3xl font-bold">{{ $totalSantri ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold">Total Guru</h3>
            <p class="text-3xl font-bold">{{ $totalGuru ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold">Total Orang Tua</h3>
            <p class="text-3xl font-bold">{{ $totalOrangtua ?? 0 }}</p>
        </div>
    </div>
</section>
@endsection
