@extends('public.layouts.app')

@section('content')

<!-- ORNAMEN ISLAMIC BESAR -->
<div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden">

    <svg class="absolute -top-20 -left-20 w-[700px] opacity-10 animate-spin-slow"
        viewBox="0 0 200 200"
        fill="none">

        <circle cx="100" cy="100" r="90" stroke="white" stroke-width="1" />

        <path d="M100 10 L120 80 L190 80 L135 120 L155 190 
                 L100 150 L45 190 L65 120 L10 80 L80 80 Z"
            stroke="white"
            stroke-width="1" />

    </svg>

</div>

<!-- HERO -->
<div class="relative text-center text-white mb-16 
opacity-0 translate-y-10 transition-all duration-1000 hero-section backdrop-blur-[2px]">

    <h1 class="text-5xl font-extralight mb-4 tracking-tight">
        TPQ Khairunissa
    </h1>

    <p class="text-lg text-emerald-300 opacity-90 max-w-2xl mx-auto font-extralight">
        Membangun Generasi Qur'ani yang Cerdas, Berakhlak, dan Berprestasi melalui Pembelajaran
        Iqra, Al-Qur'an, Sholat dan Hafalan Do'a yang benar.
    </p>

    <a href="#pendaftaran"
        class="inline-block px-8 py-3 rounded-xl font-semibold
        bg-gradient-to-r from-emerald-400 to-blue-500
        text-white shadow-lg
        hover:shadow-[0_10px_40px_rgba(16,185,129,0.5)]
        hover:scale-105 transition-all duration-300 mt-6">
        Pendaftaran Santri Baru
    </a>

</div>

<!-- STATISTIK -->
<div class="max-w-4xl mx-auto px-4">

    <div id="stats" class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">

        @php
        $stats = [
        ['icon' => 'M12 14l9-5-9-5-9 5 9 5z', 'title' => 'Santri', 'value' => $totalSantri],
        ['icon' => 'M17 20h5V4H2v16h5 M9 20v-6h6v6', 'title' => 'Guru', 'value' => $totalGuru],
        ['icon' => 'M17 20h5V4H2v16h5 M12 10a4 4 0 100-8 4 4 0 000 8z', 'title' => 'Orang Tua', 'value' => $totalOrangtua],
        ];
        @endphp

        @foreach($stats as $stat)

        <div class="stat-card opacity-0 translate-y-10 transition-all duration-700
        bg-white/5 backdrop-blur-xl border border-white/10
        rounded-2xl p-7 text-center
        shadow-[0_10px_30px_rgba(0,0,0,0.3)]
        hover:shadow-[0_20px_60px_rgba(59,130,246,0.3)]
        hover:-translate-y-2">

            <div class="flex justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-10 h-10 text-white"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="{{ $stat['icon'] }}" />

                </svg>
            </div>

            <h2 class="text-3xl font-bold text-white stat-number">
                {{ $stat['value'] }}
            </h2>

            <p class="text-white/80 text-sm">
                {{ $stat['title'] }}
            </p>

        </div>

        @endforeach

    </div>
</div>

<!-- MENU UTAMA -->
<div id="menu" class="grid md:grid-cols-3 gap-10 max-w-6xl mx-auto px-4">

    @php
    $menus = [
    [
    'icon' => 'M12 14l9-5-9-5-9 5 9 5z',
    'title' => 'Data Santri',
    'desc' => 'Informasi lengkap data santri TPQ Khairunissa.',
    'link' => route('public.data-santri')
    ],
    [
    'icon' => 'M17 20h5V4H2v16h5',
    'title' => 'Data Guru ',
    'desc' => 'Guru yang membimbing belajar Al-Qur\'an.',
    'link' => '#'
    ],
    [
    'icon' => 'M8 7V3m8 4V3m-9 8h10m-11 8h12a2 2 0 002-2V7H4v10a2 2 0 002 2z',
    'title' => 'Jadwal Belajar',
    'desc' => 'Informasi jadwal pengajian S a n t r i TPQ Khairunissah.',
    'link' => '/jadwal'
    ],
    ];
    @endphp

    @foreach($menus as $menu)

    <a href="{{ $menu['link'] }}">
        <div class="menu-card opacity-0 translate-y-10 transition-all duration-700
        group relative overflow-hidden rounded-3xl p-[1px]
        bg-gradient-to-br from-blue/30 to-white/5 border border-white/30
        hover:from-blue-400/40 hover:to-blue-500/30">

            <div class="bg-white/5 backdrop-blur-xl border border-white/10
            rounded-3xl p-10 text-center
            h-full flex flex-col justify-between
            shadow-xl group-hover:shadow-2xl transition-all duration-500">

                <!-- ICON -->
                <div class="w-16 h-16 mx-auto mb-5 flex items-center justify-center
                rounded-2xl bg-white/20
                group-hover:bg-gradient-to-br group-hover:from-emerald-400 group-hover:to-blue-500
                group-hover:scale-110 transition-all duration-300 shadow-md">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-8 h-8 text-white"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="{{ $menu['icon'] }}" />

                    </svg>

                </div>

                <!-- TITLE -->
                <h2 class="text-xl font-semibold text-white mb-2 tracking-wide">
                    {{ $menu['title'] }}
                </h2>

                <!-- DESC -->
                <p class="text-white/80 text-sm text-justify leading-relaxed">
                    {{ $menu['desc'] }}
                </p>

                <div class="mt-6">
                    <span class="inline-block text-xs text-white/70 group-hover:text-white transition">
                        Lihat Detail →
                    </span>
                </div>

            </div>

        </div>
    </a>

    @endforeach

</div>

<!-- GALERI -->
<div class="mt-10">

    <h2 class="text-3xl font-extralight text-center text-white mb-10">
        Galeri Kegiatan TPQ
    </h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-6xl mx-auto px-4">
        @forelse($galeris as $item)
        <div class="group relative overflow-hidden rounded-xl  border-emerald-300/20 border-4 shadow-20px-[0_10px_30px_rgba(0,0,0,0.3)] hover:shadow-2xl transition-all duration-300">

            <div class="aspect-[3/2]">
                <img src="{{ asset('uploads/galeri/' . $item->foto) }}"
                    onclick="openModal(this.src)"
                    class="w-full h-full object-cover cursor-pointer relative z-10">
            </div>

            <div class="absolute inset-0 bg-black/60 opacity-0 
    group-hover:opacity-100 transition duration-300 
    flex items-center justify-center
    pointer-events-none z-20">

                <p class="text-white text-sm px-2 text-center font-semibold drop-shadow-lg">
                    {{ $item->judul ?? 'Kegiatan Santri' }}
                </p>

            </div>

        </div>

        @empty
        <p class="text-white text-center col-span-4 opacity-70">
            Belum ada foto galeri
        </p>
        @endforelse

    </div>

</div>

<!-- SCRIPT -->
<script>
    document.addEventListener("DOMContentLoaded", () => {

        const observer = new IntersectionObserver(entries => {

            entries.forEach(entry => {

                if (entry.isIntersecting) {

                    entry.target.classList.remove("opacity-0", "translate-y-10")

                    if (entry.target.querySelector('.stat-number')) {
                        animateNumber(entry.target.querySelector('.stat-number'))
                    }

                }

            })

        }, {
            threshold: 0.3
        })

        document.querySelectorAll('.hero-section,.stat-card,.menu-card')
            .forEach(el => observer.observe(el))

        function animateNumber(el) {
            let target = parseInt(el.innerText)
            let count = 0
            let speed = target / 40

            const update = () => {
                count += speed
                if (count < target) {
                    el.innerText = Math.floor(count)
                    requestAnimationFrame(update)
                } else {
                    el.innerText = target
                }
            }

            update()
        }

    })
</script>
<script>
    function openModal(src) {
        const modal = document.getElementById('imageModal');
        const img = document.getElementById('modalImage');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        img.src = src;
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

<!-- MODAL -->
<div id="imageModal"
    class="fixed inset-0 bg-black/90 hidden z-50 items-center justify-center">

    <!-- klik luar -->
    <div class="absolute inset-0" onclick="closeModal()"></div>

    <!-- tombol close -->
    <button onclick="closeModal()"
        class="absolute top-5 right-5 text-white text-4xl z-50">
        ✕
    </button>

    <!-- gambar -->
    <img id="modalImage"
        class="max-w-[90%] max-h-[90%] object-contain rounded-xl shadow-2xl">
</div>
@endsection