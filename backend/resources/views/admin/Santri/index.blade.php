@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6 px-4 sm:px-6 lg:px-8">

    {{-- HEADER --}}
    <div class="flex items-center justify-between gap-4 mb-3">
        <div>
            <h1 class="text-2xl font-extralight tracking-wide text-slate-800">
                Data Santri
            </h1>
            <p class="text-xs text-slate-500 font-light mt-1">
                Kelola data base santri versi Tabel dan versi Card
            </p>
        </div>

        <div class="flex items-center gap-2">
            {{-- BUTTON PENDAFTARAN --}}
            <a href="{{ route('pendaftaran-santri.index') }}"
                class="inline-flex items-center justify-center px-3 py-1 rounded-xl border border-slate-400 bg-slate-50 text-slate-700 text-xs font-extralight hover:bg-slate-300 transition shadow-sm">
                Pendaftaran Santri Baru
            </a>
        </div>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
    <div class="mb-3 px-4 py-2 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm font-extralight">
        {{ session('success') }}
    </div>
    @endif

    {{-- FILTER + SEARCH --}}
    <form id="filterForm" method="GET" action="{{ route('santri.index') }}"
        class="px-3 py-2 border border-slate-200 bg-slate-50 rounded-2xl mb-3 shadow-sm">

        <div class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">

            {{-- Nama --}}
            <div>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama santri..."
                    class="js-filter w-full rounded-xl border border-slate-200 px-3 py-2 text-sm font-extralight
                       focus:outline-none focus:ring-2 focus:ring-slate-200">
            </div>

            {{-- Kelas --}}
            <div>
                <select name="kelas"
                    class="js-filter w-full rounded-xl border border-slate-200 px-3 py-2 text-sm font-extralight
                       focus:outline-none focus:ring-2 focus:ring-slate-200">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                    <option value="{{ $kelas }}" {{ ($kelasFilter ?? '') == $kelas ? 'selected' : '' }}>
                        {{ $kelas }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- JK --}}
            <div>
                <select name="jk"
                    class="js-filter w-full rounded-xl border border-slate-200 px-3 py-2 text-sm font-extralight
                       focus:outline-none focus:ring-2 focus:ring-slate-200">
                    <option value="">Semua Jenis Kelamin</option>
                    <option value="L" {{ ($jkFilter ?? '')=='L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ ($jkFilter ?? '')=='P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            {{-- Reset --}}
            <a href="{{ route('santri.index') }}"
                class="w-full rounded-xl border border-slate-200 bg-white text-slate-700 px-4 py-2 text-sm font-extralight
                   hover:bg-slate-300 transition text-center">
                Reset
            </a>

            {{-- Tombol Download PDF --}}
            <a href="{{ route('santri.pdf', request()->query()) }}"
                class="w-full rounded-xl border border-slate-200 bg-white text-slate-700 px-4 py-2 text-sm font-extralight
                   hover:bg-slate-300 transition text-center">
                Download Data Santri
            </a>

        </div>
    </form>

    {{-- SWITCH VIEW --}}
    <div class="flex items-center gap-2 mb-3">
        <div class="inline-flex rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm">
            <button id="btnTable" type="button"
                class="px-3 py-1 text-sm font-extralight transition bg-slate-400 text-white">
                Tabel
            </button>

            <button id="btnCard" type="button"
                class="px-3 py-1 text-xs font-extralight transition bg-white text-slate-700 border-l border-slate-200 hover:bg-slate-50">
                Card
            </button>
        </div>
    </div>

    {{-- TABLE VIEW --}}
    <div id="tableView" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="min-w-full text-[13px] table-fixed">
                <thead class="bg-slate-200 text-slate-600">
                    <tr class="text-left">
                        <th class="px-3 py-2 w-[60px] text-center font-medium ">No</th>
                        <th class="px-3 py-2 w-[280px] font-medium ">Nama Santri</th>
                        <th class="px-3 py-2 w-[120px] text-center font-medium">JK</th>
                        <th class="px-3 py-2 w-[160px] text-center font-medium">Kelas</th>
                        @if(auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin')
                        <th class="px-3 py-2 w-[200px] text-center font-medium">Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($santris as $i => $s)
                    <tr class="hover:bg-slate-50/60 transition">

                        <td class="px-3 py-2 text-center text-slate-500 font-extralight">
                            {{ ($santris->currentPage() - 1) * $santris->perPage() + $i + 1 }}
                        </td>

                        <td class="px-3 py-2">
                            <div class="text-slate-800 font-extralight">{{ $s->nama }}</div>
                            <div class="text-xs text-slate-500 font-extralight mt-1">
                                NIS: {{ $s->nis ?? '-' }}
                            </div>

                        </td>

                        <td class="px-3 py-2 text-center">
                            {{ $s->jk ?? '-' }}
                        </td>

                        <td class="px-3 py-2 text-center text-slate-700 font-extralight">
                            {{ $s->kelas ?? '-' }}
                        </td>

                        @if(auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin')
                        <td class="px-3 py-2 text-center space-x-1">
                            <a href="{{ route('santri.edit',$s->id) }}"
                                class="inline-flex items-center justify-center px-3 py-1 rounded-xl
                                    bg-slate-400 text-white text-xs font-extralight hover:bg-slate-800 transition shadow-sm">
                                Edit
                            </a>
                        </td>
                        @endif

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-3 py-6 text-center text-slate-500 font-extralight">
                            Data santri belum ada.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    {{-- CARD VIEW --}}
    <div id="cardView" class="hidden grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
        @foreach($santris as $s)
        @php
        $tgl = $s->tgl_lahir;
        $usia = $tgl ? \Carbon\Carbon::parse($tgl)->age : '-';
        $jkText = $s->jk == 'L' ? 'Laki-laki' : ($s->jk == 'P' ? 'Perempuan' : '-');

        $orangtua = optional($s->orangtua);
        $ayah = $orangtua->nama_ayah ?? '-';
        $ibu = $orangtua->nama_ibu ?? '-';
        $pekerjaanAyah = $orangtua->pekerjaan_ayah ?? '-';
        $pekerjaanIbu = $orangtua->pekerjaan_ibu ?? '-';
        $alamat = $orangtua->alamat ?? '-';
        $kontak = $orangtua->no_kontak ?? '-';

        $guru = optional($s->guru)->nama ?? '-';
        $today = now()->translatedFormat('d F Y');

        $statusSosial = $s->status_santri ?? '-';
        $tglLahirText = $tgl ? \Carbon\Carbon::parse($tgl)->translatedFormat('d F Y') : '-';

        // PROGRES IQRA
        $progresIqra = optional($s->progresIqra);
        $iqra = $progresIqra->iqra ?? '-';
        $halIqra = $progresIqra->hal ?? '-';
        $statusIqra = $progresIqra->status ?? '-';
        $statusIqraLower = strtolower($statusIqra);

        // FIX FINAL LOGIC
        $aksiIqra = null;

        if (str_contains($statusIqraLower, 'belum')) {
        $aksiIqra = 'mengulang pembelajaran';
        } elseif (str_contains($statusIqraLower, 'lancar')) {
        $aksiIqra = 'melanjutkan pembelajaran';
        }
        if (str_contains($statusIqraLower, 'belum')) {
        $aksiIqra = 'mengulang pembelajaran';
        } elseif (str_contains($statusIqraLower, 'sudah')) {
        $aksiIqra = 'melanjutkan pembelajaran berikutnya';
        }
        // PROGRES AL QURAN
        $progresAlquran = optional($s->progresAlquran);
        $juz = $progresAlquran->juz ?? '-';
        $halAlquran = $progresAlquran->hal ?? '-';
        $statusAlquran = $progresAlquran->progres ?? '-';

        // LOGIC AKSI AL QURAN
        $aksiAlquran = '-';
        if (strtolower($statusAlquran) == 'belum lcr') {
        $aksiAlquran = 'mengulang pembelajaran';
        } elseif (strtolower($statusAlquran) == 'sudah lcr') {
        $aksiAlquran = 'melanjutkan pembelajaran berikutnya';
        }

        // NARASI IQRA
        $narasiIqra = "{$s->nama}, adalah santri TPQ Khairunissa Ternate dengan Nomor Induk Santri {$s->nis}.
        kelas {$s->kelas} -
        Berjenis kelamin {$jkText}, berusia {$usia} tahun, kelahiran {$tglLahirText}.
        Merupakan anak {$statusSosial} dari orang tua {$ayah}, pekerjaan {$pekerjaanAyah},
        dan {$ibu}, pekerjaan {$pekerjaanIbu}.
        Berdomisili di {$alamat} dengan nomor kontak {$kontak}.
        Guru dari santri adalah {$guru}.
        Terupdate sampai dengan tanggal {$today}, progres belajar santri adalah belajar {$s->kelas},
        Jilid {$iqra}, halaman {$halIqra}, kategori {$statusIqra}.";

        if ($aksiIqra !== null) {
        $narasiIqra .= " Maka santri wajib untuk {$aksiIqra}.";
        }

        // NARASI AL QURAN
        $narasiAlquran = "{$s->nama}, adalah santri TPQ Khairunissa Ternate dengan Nomor Induk Santri {$s->nis}.Kelas {$s->kelas}
        Jenis kelamin {$jkText}, berusia {$usia} tahun, kelahiran {$tglLahirText}.
        Merupakan anak {$statusSosial} dari orang tua {$ayah}, pekerjaan {$pekerjaanAyah},
        dan {$ibu}, pekerjaan {$pekerjaanIbu}.
        Berdomisili di {$alamat} dengan nomor kontak {$kontak}.
        Guru dari santri adalah {$guru}.
        Terupdate sampai dengan tanggal {$today}, progres belajar santri adalah belajar {$s->kelas},
        Juz {$juz}, halaman {$halAlquran}, kategori {$statusAlquran}.
        Maka santri wajib untuk {$aksiAlquran}.";

        // PILIH NARASI
        $kelas = strtolower(str_replace(['-', '_'], ' ', $s->kelas));

        if (str_contains($kelas, 'iqra')) {
        $narasiFinal = $narasiIqra;
        } elseif (str_contains($kelas, 'quran')) {
        $narasiFinal = $narasiAlquran;
        } else {
        $narasiFinal = "Data kelas santri belum sesuai atau belum ditentukan.";
        }
        @endphp

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 flex flex-col items-center gap-3">

            <img src="{{ $s->foto ? asset('storage/'.$s->foto) : asset('images/default.png') }}"
                class="w-24 h-24 rounded-full object-cover border border-slate-200">

            <div class="text-slate-800 font-bold uppercase text-center">{{ $s->nama }}</div>

            <p id="narasi-{{ $s->id }}" class="text-xs text-slate-600 leading-relaxed font-extralight text-justify">
                {{ $narasiFinal }}
            </p>



            <div class="flex items-center justify-center gap-2 mt-2">

                <button onclick="speakText('narasi-{{ $s->id }}')"
                    class="px-3 py-1.5 rounded-lg
           bg-blue-800 text-white text-xs
           hover:bg-slate-700 transition">
                    🔊 Baca
                </button>

                @if(auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin')
                <a href="{{ route('santri.edit',$s->id) }}"
                    class="px-3 py-1.5 rounded-lg
           bg-blue-500 text-white text-xs
           hover:bg-slate-700 transition">
                    Edit
                </a>

                <form action="{{ route('santri.destroy',$s->id) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Hapus data santri ini?')"
                        class="px-3 py-1.5 rounded-lg
               bg-blue-300 text-white text-xs
               hover:bg-slate-700 transition">
                        Hapus
                    </button>
                </form>
                @endif
            </div>

        </div>
        @endforeach
    </div>
    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $santris->links() }}
    </div>

</div>

{{-- LIVE FILTER + SWITCH SCRIPT --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("filterForm");
        if (form) {
            const inputs = form.querySelectorAll(".js-filter");
            let typingTimer;
            inputs.forEach((el) => {
                if (el.tagName === "INPUT") {
                    el.addEventListener("input", () => {
                        clearTimeout(typingTimer);
                        typingTimer = setTimeout(() => {
                            form.submit();
                        }, 500);
                    });
                } else {
                    el.addEventListener("change", () => {
                        form.submit();
                    });
                }
            });
        }

        const btnTable = document.getElementById('btnTable');
        const btnCard = document.getElementById('btnCard');
        const tableView = document.getElementById('tableView');
        const cardView = document.getElementById('cardView');

        btnTable.onclick = () => {
            tableView.classList.remove('hidden');
            cardView.classList.add('hidden');
            btnTable.className = "px-3 py-1 text-xs font-extralight transition bg-slate-400 text-white";
            btnCard.className = "px-3 py-1 text-xs font-extralight transition bg-white text-slate-900 border-l border-slate-200 hover:bg-slate-50";
        };

        btnCard.onclick = () => {
            cardView.classList.remove('hidden');
            tableView.classList.add('hidden');
            btnCard.className = "px-3 py-1 text-xs font-extralight transition bg-slate-400 text-white";
            btnTable.className = "px-3 py-1 text-xs font-extralight transition bg-white text-slate-900 border-l border-slate-200 hover:bg-slate-50";
        };
    });
</script>
<script>
    function speakText(id) {
        const text = document.getElementById(id).innerText;

        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'id-ID';
        utterance.rate = 0.95;
        utterance.pitch = 1;

        window.speechSynthesis.cancel();
        window.speechSynthesis.speak(utterance);
    }
</script>
@endsection