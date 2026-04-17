@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">

    <!-- HEADER -->
    <div class="flex items-start justify-between mb-5">
        <div>
            <h1 class="text-2xl font-semibold text-black">Tambah Data Guru</h1>
            <p class="text-sm text-gray-600 mt-1">
                Isi data guru dengan lengkap. Data akan masuk ke menu Data Guru.
            </p>
        </div>

        <a href="{{ route('guru.index') }}"
           class="px-4 py-2 rounded-lg bg-slate-200 hover:bg-slate-300 text-sm font-medium transition">
            ← Kembali
        </a>
    </div>

    <!-- ALERT ERROR GLOBAL -->
    @if($errors->any())
        <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
            <p class="font-semibold mb-2">Ada data yang belum benar:</p>
            <ul class="list-disc ml-5 space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- CARD FORM -->
    <div class="bg-white rounded-2xl shadow p-6 border border-gray-100">

        <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <!-- NAMA -->
                <div>
                    <label class="block text-sm font-medium text-black mb-1">Nama Guru</label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                           placeholder="Contoh: Ust. Ahmad"
                           class="w-full rounded-xl border border-gray-300 px-3 py-2
                                  focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                    @error('nama')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIG (AUTO) -->
                <div>
                    <label class="block text-sm font-medium text-black mb-1">NIG</label>
                    <input type="text" name="nig"
                           value="{{ old('nig', $nig ?? '') }}"
                           readonly
                           class="w-full rounded-xl border border-gray-200 bg-gray-100 px-3 py-2 text-gray-800">
                    <p class="text-xs text-gray-500 mt-1">NIG otomatis dibuat sistem</p>
                    @error('nig')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- JK -->
                <div>
                    <label class="block text-sm font-medium text-black mb-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin"
                            class="w-full rounded-xl border border-gray-300 px-3 py-2
                                   focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin')=='L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin')=='P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- MAPEL -->
                <div>
                    <label class="block text-sm font-medium text-black mb-1">Mapel</label>
                    <select name="mapel"
                            class="w-full rounded-xl border border-gray-300 px-3 py-2
                                   focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                        <option value="">-- Pilih --</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m }}" {{ old('mapel') == $m ? 'selected' : '' }}>
                                {{ $m }}
                            </option>
                        @endforeach
                    </select>
                    @error('mapel')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- TEMPAT LAHIR -->
                <div>
                    <label class="block text-sm font-medium text-black mb-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                           placeholder="Contoh: Ternate"
                           class="w-full rounded-xl border border-gray-300 px-3 py-2
                                  focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                    @error('tempat_lahir')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- TANGGAL LAHIR -->
                <div>
                    <label class="block text-sm font-medium text-black mb-1">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" id="tgl_lahir"
                           value="{{ old('tgl_lahir') }}"
                           class="w-full rounded-xl border border-gray-300 px-3 py-2
                                  focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                    @error('tgl_lahir')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- USIA (AUTO) -->
                <div>
                    <label class="block text-sm font-medium text-black mb-1">Usia</label>
                    <input type="text" id="usia" disabled
                           class="w-full rounded-xl border border-gray-200 bg-gray-100 px-3 py-2 text-gray-700">
                    <p class="text-xs text-gray-500 mt-1">Otomatis dihitung dari tanggal lahir</p>
                </div>

                <!-- NO KONTAK -->
                <div>
                    <label class="block text-sm font-medium text-black mb-1">No. Kontak</label>
                    <input type="text" name="no_kontak" value="{{ old('no_kontak') }}"
                           maxlength="12"
                           placeholder="Contoh: 081234567890"
                           class="w-full rounded-xl border border-gray-300 px-3 py-2
                                  focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                    @error('no_kontak')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PENDIDIKAN -->
                <div>
                    <label class="block text-sm font-medium text-black mb-1">Pendidikan</label>
                    <input type="text" name="pendidikan" value="{{ old('pendidikan') }}"
                           placeholder="Contoh: S1 Pendidikan Agama"
                           class="w-full rounded-xl border border-gray-300 px-3 py-2
                                  focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                    @error('pendidikan')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- STATUS GURU -->
                <div>
                    <label class="block text-sm font-medium text-black mb-1">Status Guru</label>
                    <select name="status_guru"
                            class="w-full rounded-xl border border-gray-300 px-3 py-2
                                   focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                        <option value="">-- Pilih --</option>
                        <option value="Aktif" {{ old('status_guru')=='Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ old('status_guru')=='Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status_guru')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- FOTO -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-black mb-1">Foto Guru (Opsional)</label>

                    <div class="flex items-center gap-4">
                        <input type="file" name="foto" id="foto"
                               class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-white">

                        <img id="preview"
                             class="w-16 h-16 rounded-xl object-cover border hidden">
                    </div>

                    @error('foto')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <p class="text-xs text-gray-500 mt-2">
                        Format: JPG/PNG. Maksimal 2MB.
                    </p>
                </div>

                <!-- ALAMAT -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-black mb-1">Alamat</label>
                    <textarea name="alamat" rows="3"
                              placeholder="Contoh: Kelurahan Gamalama RT01/RW02"
                              class="w-full rounded-xl border border-gray-300 px-3 py-2
                                     focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- ACTION -->
            <div class="flex items-center justify-end gap-3 mt-6">
                <a href="{{ route('guru.index') }}"
                   class="px-5 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-sm font-medium transition">
                    Batal
                </a>

                <button type="submit"
                        class="px-6 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition">
                    Simpan Data Guru
                </button>
            </div>

        </form>
    </div>
</div>

{{-- SCRIPT: Preview Foto + Hitung Usia --}}
<script>
    // Preview Foto
    const fotoInput = document.getElementById('foto');
    const preview = document.getElementById('preview');

    if (fotoInput) {
        fotoInput.addEventListener('change', function () {
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
        // auto hitung kalau old('tgl_lahir') ada
        hitungUsia();
    }
</script>
@endsection
