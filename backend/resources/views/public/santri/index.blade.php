@extends('public.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto text-white">

    <!-- JUDUL -->
    <h1 class="text-3xl font-extralight mb-8">
        Directory Santri TPQ Khairunissa
    </h1>

    <!-- KONTROL AUDIO -->
    <div class="mb-6 flex items-center gap-3 flex-wrap">

        <button onclick="playSantri()"
            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
            ▶ Putar
        </button>

        <button onclick="pauseSantri()"
            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
            ⏸ Pause
        </button>

        <button onclick="stopSantri()"
            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
            ⏹ Stop
        </button>

        <select id="voiceSantri"
            class="text-sm rounded px-2 py-1 text-black">
        </select>

    </div>

    <!-- ===================== -->
    <!-- STATISTIK -->
    <!-- ===================== -->
    <div class="grid grid-cols-3 md:grid-cols-9 gap-4 mb-10">

        @php
        $cards = [
        ['title' => 'Jumlah Santri', 'value' => $total],
        ['title' => 'Laki-laki', 'value' => $laki],
        ['title' => 'Perempuan', 'value' => $perempuan],

        ['title' => 'Kelas Quran', 'value' => $quran],
        ['title' => 'Kelas Iqra', 'value' => $iqra],
        ['title' => 'Anak Yatim', 'value' => $yatim],

        ['title' => 'Anak Piatu', 'value' => $piatu],
        ['title' => 'Yatim Piatu', 'value' => $yatimPiatu],
        ['title' => 'Santunan OT', 'value' => $santunan],
        ];
        @endphp

        @foreach($cards as $card)
        <div class="aspect-square 
        bg-white/10 backdrop-blur-md 
        rounded-xl flex flex-col items-center justify-center
        border border-white/20 shadow-md hover:scale-105 transition">

            <h2 class="text-lg md:text-xl font-bold">
                {{ $card['value'] ?? 0 }}
            </h2>

            <p class="text-[13px] font-light md:text-xs text-white/80 mt-2 text-center px-1">
                {{ $card['title'] }}
            </p>

        </div>
        @endforeach

    </div>
</div>

<!-- ===================== -->
<!-- DATA UTAMA -->
<!-- ===================== -->
<div class="grid md:grid-cols-3 gap-6">

    <!-- RINGKASAN -->
    <div class="bg-white/10 p-6 rounded-2xl md:col-span-1">

        <h2 class="text-xl mb-4">📊 Ringkasan</h2>

        <p class="text-sm font-light leading-relaxed text-white/80 text-justify">
            TPQ Khairunissa Ternate sampai hari ini tanggal
            <span class="font-semibold text-white">{{ \Carbon\Carbon::now()->format('d F Y') }}</span>
            membina sebanyak
            <span class="font-semibold text-white">{{ $total }}</span> santri,
            terdiri dari
            <span class="font-semibold text-white">{{ $laki }}</span> santri laki-laki dan
            <span class="font-semibold text-white">{{ $perempuan }}</span> santri perempuan.

            Santri diklasifikasi berdasarkan kelas:
            Iqra sebanyak
            <span class="font-semibold text-white">{{ $iqra }}</span> anak,
            dan Al-Qur’an sebanyak
            <span class="font-semibold text-white">{{ $quran }}</span> anak.

            TAMBAH NARASI ... Dengan rincian status:
            • Anak Yatim: <span class="text-white">{{ $yatim }}</span>
            • Anak Piatu: <span class="text-white">{{ $piatu }}</span>
            • Anak Yatim Piatu: <span class="text-white">{{ $yatimPiatu }}</span>
            • Santunan Orang Tua: <span class="text-white">{{ $santunan }}</span>
        </p>

    </div>

    <!-- KELAS -->
    <div class="bg-white/10 p-6 rounded-2xl">
        <h2 class="text-xl mb-4">🎓 Kelas Santri</h2>

        @foreach($kelas as $item)
        <div class="flex justify-between text-sm font-light border-b border-white/10 py-1">
            <span>Santri Kelas {{ $item->kelas ?? '-' }}</span>
            <span>{{ $item->total }} - Anak</span>
        </div>
        @endforeach
    </div>

    <!-- PROGRES -->
    <div class="bg-white/10 p-6 font-light rounded-2xl">

        <h2 class="text-xl mb-4">📖 Progres Santri</h2>

        <p class="text-xs text-white/70 mb-4">
            Update terakhir progres belajar santri sampai tanggal
            {{ \Carbon\Carbon::now()->format('d F Y') }}
        </p>

        <!-- PROGRES AL QURAN -->

        <div class="flex justify-between border-b border-white/10 py-2 text-sm">

            <span class="font-semibold">Al Quran</span>

            <span>Ulang : {{ $progresQuran->ulang ?? 0 }}</span>

            <span>Lanjut : {{ $progresQuran->lanjut ?? 0 }}</span>

        </div>


        <!-- PROGRES IQRA -->

        @for($i=1; $i<=6; $i++)

            <div class="flex justify-between border-b border-white/10 py-2 text-sm">

            <span class="font-semibold">Iqra {{ $i }}</span>

            <span>Ulang : {{ $progresIqra[$i]->ulang ?? 0 }}</span>

            <span>Lanjut : {{ $progresIqra[$i]->lanjut ?? 0 }}</span>

    </div>

    @endfor
</div>

</div>

<!-- ===================== -->
<!-- GRAFIK -->
<!-- ===================== -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">

    <!-- GRAFIK PROGRES BELAJAR -->

    <div class="bg-white/10 p-6 rounded-2xl flex flex-col min-h-[320px]">
        <h2 class="mb-4">📖 Grafik Progres</h2>

        <div class="flex-1">
            <canvas id="progresChart"></canvas>
        </div>
    </div>

    <!-- GENDER -->
    <div class="bg-white/10 p-6 rounded-2xl flex flex-col min-h-[320px]">
        <h2 class="mb-4">👦 Grafik Gender</h2>

        <div class="flex-1">
            <canvas id="genderChart"></canvas>
        </div>
    </div>

    <!-- KELAS -->
    <div class="bg-white/10 p-6 rounded-2xl flex flex-col min-h-[320px]">
        <h2 class="mb-4">🎓 Grafik Kelas</h2>

        <div class="flex-1">
            <canvas id="kelasChart"></canvas>
        </div>
    </div>

</div>

</div>

<!-- DATA UNTUK JS -->
<div id="chart-data"
    data-laki="{{ $laki }}"
    data-perempuan="{{ $perempuan }}"
    data-kelas='@json($kelas)'
    data-progres-iqra='@json($progresIqra)'
    data-progres-quran='@json($progresQuran)'>
</div>

<!-- SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    window.addEventListener("load", function() {

        const el = document.getElementById('chart-data');

        const laki = Number(el.dataset.laki) || 0;
        const perempuan = Number(el.dataset.perempuan) || 0;

        const kelasRaw = JSON.parse(el.dataset.kelas || '[]');

        const kelasLabels = kelasRaw.map(item => item.kelas ?? '-');
        const kelasData = kelasRaw.map(item => Number(item.total) || 0);

        let genderChart, kelasChart;

        function renderCharts() {

            const genderCanvas = document.getElementById('genderChart');
            const kelasCanvas = document.getElementById('kelasChart');

            if (genderChart) genderChart.destroy();
            if (kelasChart) kelasChart.destroy();

            genderChart = new Chart(genderCanvas, {
                type: 'doughnut',
                data: {
                    labels: ['Laki-laki', 'Perempuan'],
                    datasets: [{
                        data: [laki, perempuan],
                        backgroundColor: ['#205aa2', '#31a2f2']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#ffffff'
                            }
                        }
                    }
                }
            });

            kelasChart = new Chart(kelasCanvas, {
                type: 'bar',
                data: {
                    labels: kelasLabels,
                    datasets: [{
                        label: "Jumlah Santri",
                        data: kelasData,
                        backgroundColor: '#60a5fa'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#ffffff'
                            }
                        }
                    }
                }
            });
        }

        renderCharts();

        window.addEventListener('resize', () => {
            renderCharts();
        });

        const progresIqra = JSON.parse(el.dataset.progresIqra || '{}');
        const progresQuran = JSON.parse(el.dataset.progresQuran || '{}');

        let labels = ['Al Quran'];
        let ulangData = [progresQuran.ulang || 0];
        let lanjutData = [progresQuran.lanjut || 0];

        for (let i = 1; i <= 6; i++) {

            let data = progresIqra[i] || {};

            labels.push("Iqra " + i);

            ulangData.push(data.ulang || 0);

            lanjutData.push(data.lanjut || 0);

        }

        const progresCanvas = document.getElementById('progresChart');

        new Chart(progresCanvas, {

            type: 'bar',

            data: {

                labels: labels,

                datasets: [{
                        label: 'Ulang',
                        data: ulangData,
                        backgroundColor: '#f59e0b'
                    },
                    {
                        label: 'Lanjut',
                        data: lanjutData,
                        backgroundColor: '#22c55e'
                    }
                ]

            },

            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#ffffff'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#ffffff'
                        }
                    },
                    y: {
                        ticks: {
                            color: '#ffffff'
                        }
                    }
                }
            }

        });

    });
</script>

<script>
    let speechSantri;
    let voicesSantri = [];

    function loadVoicesSantri() {

        voicesSantri = speechSynthesis.getVoices();

        let select = document.getElementById("voiceSantri");

        select.innerHTML = "";

        voicesSantri.forEach((voice, i) => {

            if (
                voice.lang.includes("id") ||
                voice.lang.includes("en")
            ) {

                let option = document.createElement("option");

                option.value = i;

                option.text = voice.name + " (" + voice.lang + ")";

                select.appendChild(option);

            }

        });

    }

    speechSynthesis.onvoiceschanged = loadVoicesSantri;



    function playSantri() {

        let teks = `
Direktori Santri TPQ Khairunissa.

Sampai tanggal {{ $tanggal }}.

TPQ Khairunissa membina sebanyak {{ $total }} santri.

Terdiri dari {{ $laki }} santri laki laki dan {{ $perempuan }} santri perempuan.

Santri kelas Iqra sebanyak {{ $iqra }} anak.

Santri kelas Al Quran sebanyak {{ $quran }} anak.

Status santri terdiri dari.

{{ $yatim }} anak yatim.

{{ $piatu }} anak piatu.

{{ $yatimPiatu }} anak yatim piatu.

Dan {{ $santunan }} anak santunan orang tua.
`;

        speechSantri = new SpeechSynthesisUtterance(teks);

        let voiceIndex = document.getElementById("voiceSantri").value;

        if (voicesSantri[voiceIndex]) {
            speechSantri.voice = voicesSantri[voiceIndex];
        }

        speechSantri.rate = 0.9;
        speechSantri.pitch = 1;

        speechSynthesis.speak(speechSantri);

    }


    function pauseSantri() {
        speechSynthesis.pause();
    }

    function stopSantri() {
        speechSynthesis.cancel();
    }

    window.onload = loadVoicesSantri;
</script>

@endsection