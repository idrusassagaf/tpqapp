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

<!-- ===================================================== -->
<!-- HEADER PROFIL -->
<!-- ===================================================== -->

<div class="text-center mb-12">

    <h1 class="text-4xl font-light mb-2">
        Profil TPQ Khairunissa
    </h1>

    <p id="deskripsiTPQ"
        class="text-blue-100 max-w-2xl mx-auto font-extralight leading-relaxed">
        TPQ Khairunissa merupakan lembaga pendidikan Al-Qur'an yang berkomitmen
        membina generasi Qur’ani yang cerdas, berakhlak mulia, dan memiliki
        semangat belajar Al-Qur'an sejak usia dini.
    </p>

    <!-- KONTROL AUDIO -->
    <div class="mt-6 flex justify-center">

        <div class="flex items-center gap-3 flex-wrap justify-center">

            <button onclick="playProfil()"
                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                ▶ Putar
            </button>

            <button onclick="pauseProfil()"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                ⏸ Pause
            </button>

            <button onclick="stopProfil()"
                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                ⏹ Stop
            </button>

            <select id="voiceSelect"
                class="text-sm rounded px-2 py-1 text-black">
            </select>

        </div>

    </div>
</div>

<!-- ===================================================== -->
<!-- PIMPINAN TPQ -->
<!-- ===================================================== -->

<div class="mb-10 ">

    <h2 class="text-2xl text-center mb-5 font-extralight">
        Pembina dan Pengurus TPQ Khairunissa
    </h2>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">

        @php
        $pimpinanFields = [
        'pembina' => ['role' => 'Pembina', 'name' => 'Ustadz Ahmad'],
        'ketua' => ['role' => 'Ketua', 'name' => 'Ustadz Rahman'],
        'sekretaris' => ['role' => 'Sekretaris', 'name' => 'Ustadzah Aisyah'],
        'bendahara' => ['role' => 'Bendahara', 'name' => 'Ustadzah Fatimah'],
        'staf1' => ['role' => 'Staf', 'name' => 'Ustadz Yusuf'],
        'staf2' => ['role' => 'Staf', 'name' => 'Ustadzah Maryam'],
        ];
        @endphp

        @foreach($pimpinanFields as $key => $data)
        <div class="bg-blue-600 rounded-2xl p-6 text-center shadow-lg">
            <img src="{{ isset($profil[$key]) ? asset('images/pimpinan/' . $profil[$key]) : asset('images/default.png') }}"
                class="w-24 h-24 mx-auto rounded-full object-cover border-4 border-white mb-4">

            <h3 class="text-white text-sm font-semibold">
                {{ $profil[$key.'_nama'] ?? $data['name'] }}
            </h3>

            <p class="text-blue-100 text-xs">
                {{ $profil[$key.'_jabatan'] ?? $data['role'] }}
            </p>
        </div>
        @endforeach

    </div>

</div>

<!-- ===================================================== -->
<!-- CONTAINER PROFIL -->
<!-- ===================================================== -->

<div class="grid md:grid-cols-2 gap-8">

    <!-- SEJARAH TPQ -->
    <div id="cardSejarah"
        class="bg-white/10 backdrop-blur-md rounded-2xl p-8 shadow-lg
hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">

        <h2 class="text-2xl mb-4 font-extralight">
            Sejarah TPQ
        </h2>

        <p class="text-blue-100 font-extralight leading-relaxed text-justify mb-3">
            {{ $profil['sejarah'] ?? 'Belum ada sejarah.' }}
        </p>

    </div>

    <!-- VISI MISI -->
    <div id="cardVisi"
        class="bg-white/10 backdrop-blur-md rounded-2xl p-8 shadow-lg
hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">

        <h2 class="text-2xl mb-4 font-extralight">
            Visi & Misi
        </h2>

        <!-- VISI -->
        <p class="text-blue-100 font-extralight mb-3 text-justify">
            <strong>Visi :</strong>
            {{ $profil['visi'] ?? 'Belum ada visi.' }}
        </p>

        <!-- MISI -->
        <ul class="list-disc pl-5 space-y-1 font-extralight text-blue-100 text-justify">
            @if(isset($profil['misi']))
            @foreach(explode("\r\n", $profil['misi']) as $m)
            <li>{{ $m }}</li>
            @endforeach
            @else
            <li>Belum ada misi.</li>
            @endif
        </ul>

    </div>


    <!-- TUJUAN -->
    <div id="cardTujuan"
        class="bg-white/10 backdrop-blur-md rounded-2xl p-8 shadow-lg
hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">

        <h2 class="text-2xl mb-4 font-extralight">
            Tujuan Pendidikan
        </h2>

        <ul class="list-disc pl-5 space-y-2 font-extralight text-blue-100 text-justify">
            @if(isset($profil['tujuan']))
            @foreach(explode("\r\n", $profil['tujuan']) as $t)
            <li>{{ $t }}</li>
            @endforeach
            @else
            <li>Belum ada tujuan.</li>
            @endif
        </ul>

    </div>

    <!-- LOKASI -->
    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 shadow-lg
hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">

        <h2 class="text-2xl mb-4 font-extralight">
            Lokasi TPQ
        </h2>

        <p class="text-blue-100 font-extralight mb-4 text-justify">
            {{ $profil['lokasi'] ?? 'Belum ada lokasi.' }}
        </p>

        <iframe
            src="https://maps.google.com/maps?q=ternate&t=&z=13&ie=UTF8&iwloc=&output=embed"
            class="w-full h-72 rounded-lg border-0">
        </iframe>

    </div>


</div>

<style>
    .highlightCard {
        background: rgba(255, 255, 255, 0.25);
        transform: scale(1.02);
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.4);
    }
</style>

<script>
    let speech;
    let voices = [];

    function loadVoices() {

        voices = speechSynthesis.getVoices();

        let select = document.getElementById("voiceSelect");

        select.innerHTML = "";

        voices.forEach((voice, i) => {

            if (
                voice.lang.includes("id") ||
                voice.lang.includes("en") ||
                voice.lang.includes("ar")
            ) {

                let option = document.createElement("option");

                option.value = i;

                let gender = "";

                if (voice.name.toLowerCase().includes("male")) {
                    gender = " - Laki-laki";
                }

                if (voice.name.toLowerCase().includes("female")) {
                    gender = " - Perempuan";
                }

                option.text = voice.name + gender + " (" + voice.lang + ")";

                select.appendChild(option);

            }

        });

    }

    speechSynthesis.onvoiceschanged = loadVoices;

    function playProfil() {

        let judul = document.querySelector("h1").innerText;
        let deskripsi = document.querySelector("#deskripsiTPQ").innerText;
        let pimpinan = "";
        document.querySelectorAll(".grid .bg-blue-600").forEach(card => {
            pimpinan += card.innerText + ". ";
        });

        let sejarah = document.querySelector("#cardSejarah").innerText;
        let visi = document.querySelector("#cardVisi").innerText;
        let tujuan = document.querySelector("#cardTujuan").innerText;

        let teks = `
    ${judul}.

    ${deskripsi}

    Pembina dan pengurus TPQ Khairunissa.

    ${pimpinan}

    ${sejarah}

    ${visi}

    ${tujuan}
    `;

        speech = new SpeechSynthesisUtterance(teks);

        let voiceIndex = document.getElementById("voiceSelect").value;

        if (voices[voiceIndex]) {
            speech.voice = voices[voiceIndex];
        }

        speech.rate = 0.9;
        speech.pitch = 1;

        speechSynthesis.speak(speech);
    }

    function pauseProfil() {
        speechSynthesis.pause();
    }

    function stopProfil() {
        speechSynthesis.cancel();
        window.onload = loadVoices;
    }
</script>

@endsection