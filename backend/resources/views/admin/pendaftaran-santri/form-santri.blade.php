@extends('layouts.app')
@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 text-sm font-extralight text-black">
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
        <div>
            <h2 class="text-2xl font-extralight text-black">Pendaftaran Santri</h2>
            <p class="text-black text-sm mt-1 opacity-80">
                Silakan isi data santri dan orang tua. NIS otomatis setelah data disimpan.
            </p>
        </div>
    </div>
    {{-- ALERT SUCCESS --}}
    @if(session('success'))
    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700 shadow-sm">
        {{ session('success') }}
    </div>
    @endif
    <form action="{{ route('pendaftaran-santri.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- ===================== FORM SANTRI ===================== --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-extralight text-black">Form Santri</h3>
                </div>
                <div class="p-5 space-y-4">
                    {{-- Nama --}}
                    <div>
                        <label class="block mb-1 text-black">Nama Santri</label>
                        <input type="text" name="nama" value="{{ old('nama') }}"
                            placeholder="Contoh: Ahmad Ramadhan"
                            class="w-full border border-gray-300 rounded-xl px-3 py-2 text-black
                                      focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                        @error('nama')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    {{-- Foto --}}
                    <div>
                        <label class="block mb-1 text-black">Foto Santri</label>
                        <div class="flex flex-col md:flex-row gap-3 items-start">
                            <input type="file" name="foto" id="foto"
                                class="w-full border border-gray-300 rounded-xl px-3 py-2 bg-white text-black">
                            <div class="w-32 h-32 rounded-2xl border border-dashed border-gray-300 overflow-hidden bg-gray-50 flex items-center justify-center">
                                <img id="preview" class="w-full h-full object-cover hidden">
                                <div id="previewPlaceholder" class="text-xs text-black opacity-60 text-center px-2">
                                    Preview foto
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- NIS --}}
                    <div>
                        <label class="block mb-1 text-black">NIS</label>
                        <input type="text"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 bg-gray-100 text-black opacity-70"
                            value="Otomatis setelah simpan" disabled>
                    </div>

                    {{-- JK --}}
                    <div>
                        <label class="block mb-1 text-black">Jenis Kelamin</label>
                        <select name="jk"
                            class="w-full border border-gray-300 rounded-xl px-3 py-2 text-black
                                       focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jk')=='L'?'selected':'' }}>Laki-laki</option>
                            <option value="P" {{ old('jk')=='P'?'selected':'' }}>Perempuan</option>
                        </select>
                        @error('jk')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Tgl Lahir + Usia --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 text-black">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" id="tgl_lahir" value="{{ old('tgl_lahir') }}"
                                class="w-full border border-gray-300 rounded-xl px-3 py-2 text-black
                                          focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                            @error('tgl_lahir')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block mb-1 text-black">Usia</label>
                            <input type="text" id="usia"
                                class="w-full border border-gray-200 rounded-xl px-3 py-2 bg-gray-100 text-black opacity-70"
                                placeholder="Otomatis" disabled>
                        </div>
                    </div>
                    {{-- Kelas --}}
                    <div>
                        <label class="block mb-1 text-black">Kelas</label>
                        <select name="kelas"
                            class="w-full border border-gray-300 rounded-xl px-3 py-2 text-black
                                       focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach(['Al Quran','Iqra 1','Iqra 2','Iqra 3','Iqra 4','Iqra 5','Iqra 6','Iqra 7','Iqra 8'] as $kelas)
                            <option value="{{ $kelas }}" {{ old('kelas')==$kelas?'selected':'' }}>{{ $kelas }}</option>
                            @endforeach
                        </select>
                        @error('kelas')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    {{-- Status Santri --}}
                    <div>
                        <label class="block mb-1 text-black">Status Santri</label>
                        <input type="text" name="status_santri" id="status_santri"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 bg-gray-100 text-black opacity-70"
                            placeholder="Otomatis sesuai status orang tua" readonly>
                        @error('status_santri')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- ===================== FORM ORANG TUA ===================== --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-extralight text-black">Form Orang Tua</h3>
                </div>

                <div class="p-5 space-y-4">
                    {{-- Nama Ayah --}}
                    <div>
                        <label class="block mb-1 text-black">Nama Ayah</label>
                        <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}"
                            placeholder="Contoh: Bapak Abdullah"
                            class="w-full border border-gray-300 rounded-xl px-3 py-2 text-black
                                      focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                        @error('nama_ayah')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    {{-- Nama Ibu --}}
                    <div>
                        <label class="block mb-1 text-black">Nama Ibu</label>
                        <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}"
                            placeholder="Contoh: Ibu Siti"
                            class="w-full border border-gray-300 rounded-xl px-3 py-2 text-black
                                      focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                        @error('nama_ibu')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    {{-- Pekerjaan --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 text-black">Pekerjaan Ayah</label>
                            <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}"
                                placeholder="Contoh: Nelayan"
                                class="w-full border border-gray-300 rounded-xl px-3 py-2 text-black
                                          focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                        </div>
                        <div>
                            <label class="block mb-1 text-black">Pekerjaan Ibu</label>
                            <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}"
                                placeholder="Contoh: Ibu Rumah Tangga"
                                class="w-full border border-gray-300 rounded-xl px-3 py-2 text-black
                                          focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                        </div>
                    </div>
                    {{-- Status Orang Tua --}}
                    <div>
                        <label class="block mb-1 text-black">Status Orang Tua</label>
                        <select name="status_orangtua" id="status_orangtua_input"
                            class="w-full border border-gray-300 rounded-xl px-3 py-2 text-black
                                       focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                            <option value="">-- Pilih Status --</option>
                            @foreach(['Keduanya Hidup','Keduanya Wafat','Ayah Wafat','Ibu Wafat'] as $status)
                            <option value="{{ $status }}" {{ old('status_orangtua')==$status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                            @endforeach
                        </select>
                        @error('status_orangtua')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    {{-- Kontak --}}
                    <div>
                        <label class="block mb-1 text-black">No. Kontak</label>
                        <input type="text" name="no_kontak" maxlength="12" value="{{ old('no_kontak') }}"
                            placeholder="Contoh: 081234567890"
                            class="w-full border border-gray-300 rounded-xl px-3 py-2 text-black
                                      focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                    </div>
                    {{-- Alamat --}}
                    <div>
                        <label class="block mb-1 text-black">Alamat</label>
                        <textarea name="alamat" rows="3"
                            placeholder="Contoh: Gamalama RT01/RW02"
                            class="w-full border border-gray-300 rounded-xl px-3 py-2 text-black
                                         focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        {{-- BUTTON --}}
        <div class="mt-6 flex items-center justify-end">
            <button type="submit"
                class="px-6 py-2 rounded-xl bg-green-600 text-white shadow-sm hover:bg-green-700 transition">
                Simpan Semua
            </button>
        </div>

    </form>
</div>

{{-- Preview Foto & Hitung Usia & Status Santri --}}
<script>
    // Preview Foto
    const fotoInput = document.getElementById('foto');
    const preview = document.getElementById('preview');
    const previewPlaceholder = document.getElementById('previewPlaceholder');
    fotoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                previewPlaceholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    // Hitung Usia otomatis
    const tglInput = document.getElementById('tgl_lahir');
    const usiaInput = document.getElementById('usia');
    const statusInput = document.getElementById('status_santri');
    const statusOrtuInput = document.getElementById('status_orangtua_input');
    tglInput.addEventListener('change', function() {
        const birth = new Date(this.value);
        const today = new Date();
        let age = today.getFullYear() - birth.getFullYear();
        const m = today.getMonth() - birth.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) {
            age--;
        }
        usiaInput.value = age + ' Tahun';
    });
    // Set Status Santri otomatis sesuai Status Orang Tua
    statusOrtuInput.addEventListener('change', function() {
        let statusAnak = '';
        switch (this.value) {
            case 'Keduanya Hidup':
                statusAnak = 'Santunan Orangtua';
                break;
            case 'Keduanya Wafat':
                statusAnak = 'Yatim Piatu';
                break;
            case 'Ayah Wafat':
                statusAnak = 'Yatim';
                break;
            case 'Ibu Wafat':
                statusAnak = 'Piatu';
                break;
        }
        statusInput.value = statusAnak;
    });
</script>
@endsection