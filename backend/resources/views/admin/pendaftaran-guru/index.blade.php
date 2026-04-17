@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto font-extralight text-[15px] text-slate-700">

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
    <div class="mb-5 p-4 rounded-2xl bg-emerald-50 border border-emerald-400 text-emerald-700 text-sm">
        {{ session('success') }}
    </div>
    @endif

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl font-extralight text-black">Pendaftaran Guru</h1>
        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
            Penginputan Master Data Guru. Data otomatis tersimpan di semua fitur
            <span class="text-slate-700 font-extralight">Data Guru</span>.
        </p>
    </div>

    {{-- ALERT ERROR GLOBAL --}}
    @if($errors->any())
    <div class="mb-5 p-4 rounded-2xl bg-rose-50 border border-rose-400 text-rose-700 text-sm">
        <p class="font-medium mb-2">Ada data yang belum benar:</p>
        <ul class="list-disc ml-5 space-y-1">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- CARD FORM --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

        {{-- TOP STRIP --}}
        <div class="bg-white rounded-2xl shadow-sm border border-blue-300 overflow-hidden">
            <div class="px-5 py-4 bg-gray-300 border-b border-blue-200">
                <h3 class="text-lg font-extralight text-black">Form Guru</h3>
            </div>

            <div class="p-6">
                <form action="{{ route('pendaftaran-guru.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1  md:grid-cols-2 gap-5">

                        {{-- NAMA --}}
                        <div>
                            <label class="block text-sm font-extralight text-slate-800 mb-1">Nama Guru</label>
                            <input type="text" name="nama" value="{{ old('nama') }}"
                                placeholder="Contoh: Ust. Ahmad"
                                class="w-full rounded-2xl border border-slate-400 px-4 py-2.5
                                      bg-white text-slate-800 placeholder:text-slate-400
                                      focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-sky-300">
                            @error('nama')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- NIG AUTO --}}
                        <div>
                            <label class="block text-sm font-extralight text-slate-800 mb-1">NIG</label>
                            <input type="text" name="nig"
                                value="{{ old('nig', $nig ?? '') }}"
                                readonly
                                class="w-full rounded-2xl border border-slate-400 bg-slate-100 px-4 py-2.5 text-slate-800">
                            <p class="text-xs text-slate-500 mt-1">NIG otomatis dibuat sistem</p>
                            @error('nig')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- JK --}}
                        <div>
                            <label class="block text-sm font-extralight text-slate-800 mb-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin"
                                class="w-full rounded-2xl border border-slate-400 px-4 py-2.5
                                       bg-white text-slate-800
                                       focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-sky-300">
                                <option value="">-- Pilih --</option>
                                <option value="L" {{ old('jenis_kelamin')=='L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin')=='P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- MAPEL --}}
                        <div>
                            <label class="block text-sm font-extralight text-slate-800 mb-1">Mapel</label>
                            <select name="mapel"
                                class="w-full rounded-2xl border border-slate-400 px-4 py-2.5
                                       bg-white text-slate-800
                                       focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-sky-300">
                                <option value="">-- Pilih --</option>
                                @foreach($mapelList as $m)
                                <option value="{{ $m }}" {{ old('mapel') == $m ? 'selected' : '' }}>
                                    {{ $m }}
                                </option>
                                @endforeach
                            </select>
                            @error('mapel')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- TEMPAT LAHIR --}}
                        <div>
                            <label class="block text-sm font-extralight text-slate-800 mb-1">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                placeholder="Contoh: Ternate"
                                class="w-full rounded-2xl border border-slate-400 px-4 py-2.5
                                      bg-white text-slate-800 placeholder:text-slate-400
                                      focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-sky-300">
                            @error('tempat_lahir')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- TANGGAL LAHIR --}}
                        <div>
                            <label class="block text-sm font-extralight text-slate-800 mb-1">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" id="tgl_lahir"
                                value="{{ old('tgl_lahir') }}"
                                class="w-full rounded-2xl border border-slate-400 px-4 py-2.5
                                      bg-white text-slate-800
                                      focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-sky-300">
                            @error('tgl_lahir')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- USIA AUTO --}}
                        <div>
                            <label class="block text-sm font-extralight text-slate-800 mb-1">Usia</label>
                            <input type="text" id="usia" disabled
                                placeholder="Otomatis"
                                class="w-full rounded-2xl border border-slate-400 bg-slate-100 px-4 py-2.5 text-slate-700">
                            <p class="text-xs text-slate-500 mt-1">Otomatis dihitung dari tanggal lahir</p>
                        </div>

                        {{-- NO KONTAK --}}
                        <div>
                            <label class="block text-sm font-extralight text-slate-800 mb-1">No. Kontak</label>
                            <input type="text" name="no_kontak" value="{{ old('no_kontak') }}"
                                maxlength="12"
                                placeholder="Contoh: 081234567890"
                                class="w-full rounded-2xl border border-slate-400 px-4 py-2.5
                                      bg-white text-slate-800 placeholder:text-slate-400
                                      focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-sky-300">
                            @error('no_kontak')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- PENDIDIKAN --}}
                        <div>
                            <label class="block text-sm font-extralight text-slate-800 mb-1">Pendidikan</label>
                            <input type="text" name="pendidikan" value="{{ old('pendidikan') }}"
                                placeholder="Contoh: S1 Pendidikan Agama"
                                class="w-full rounded-2xl border border-slate-400 px-4 py-2.5
                                    bg-white text-slate-800 placeholder:text-slate-400
                                    focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-sky-300">
                            @error('pendidikan')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- FOTO --}}
                        <div>
                            <label class="block text-sm font-extralight text-slate-800 mb-1">Foto Guru (Opsional)</label>

                            <div class="flex items-center gap-4">
                                <input type="file" name="foto" id="foto"
                                    class="w-full rounded-2xl border border-slate-400 px-4 py-2.5 bg-white">

                                <img id="preview"
                                    class="w-16 h-16 rounded-2xl object-cover border border-slate-200 hidden">
                            </div>

                            @error('foto')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror

                            <p class="text-xs text-slate-500 mt-2">
                                Format: JPG/PNG. Maksimal 2MB.
                            </p>
                        </div>


                        {{-- ALAMAT --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-extralight text-slate-800 mb-1">Alamat</label>
                            <textarea name="alamat" rows="3"
                                placeholder="Contoh: Kelurahan Gamalama RT01/RW02"
                                class="w-full rounded-2xl border border-slate-400 px-4 py-2.5
                                         bg-white text-slate-800 placeholder:text-slate-400
                                         focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-sky-300">{{ old('alamat') }}</textarea>
                            @error('alamat')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- ACTION --}}
                    <div class="flex items-center justify-end gap-3 mt-7">
                        <span>TELITI DATA SEBELUM DI SIMPAN</span>
                        <a href="{{ route('dashboard') }}"
                            class="px-6 py-2 rounded-xl bg-slate-300 text-slate-900 shadow-sm hover:bg-slate-400 transition">
                            Batal
                        </a>

                        <button type="submit"
                            class="px-6 py-2 rounded-xl bg-slate-300 text-slate-900 shadow-sm hover:bg-slate-400 transition">
                            Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPT: Preview Foto + Hitung Usia --}}
    <script>
        // Preview Foto
        const fotoInput = document.getElementById('foto');
        const preview = document.getElementById('preview');

        if (fotoInput) {
            fotoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Hitung usia otomatis
        const tglInput = document.getElementById('tgl_lahir');
        const usiaInput = document.getElementById('usia');

        function hitungUsia() {
            if (!tglInput.value) return;

            const birth = new Date(tglInput.value);
            const today = new Date();

            let age = today.getFullYear() - birth.getFullYear();
            const m = today.getMonth() - birth.getMonth();

            if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) {
                age--;
            }

            usiaInput.value = age + ' Tahun';
        }

        if (tglInput) {
            tglInput.addEventListener('change', hitungUsia);
            hitungUsia();
        }
    </script>
    @endsection