@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <h1 class="text-2xl font-light mb-6">
        Edit Profil Website
    </h1>

    <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- SEJARAH -->
        <div class="card-modern p-6 mb-6">
            <h2 class="text-lg mb-3">Sejarah TPQ</h2>

            <textarea name="sejarah" rows="5"
                class="w-full border rounded-lg p-3 text-sm">

            {{ $profil['sejarah'] ?? '' }}

            </textarea>
        </div>


        <!-- VISI -->
        <div class="card-modern p-6 mb-6">
            <h2 class="text-lg mb-3">Visi</h2>

            <textarea name="visi" rows="3"
                class="w-full border rounded-lg p-3 text-sm">

            {{ $profil['visi'] ?? '' }}

            </textarea>
        </div>


        <!-- MISI -->
        <div class="card-modern p-6 mb-6">
            <h2 class="text-lg mb-3">Misi</h2>

            <textarea name="misi" rows="4"
                class="w-full border rounded-lg p-3 text-sm">

            {{ $profil['misi'] ?? '' }}

            </textarea>
        </div>


        <!-- TUJUAN -->
        <div class="card-modern p-6 mb-6">
            <h2 class="text-lg mb-3">Tujuan Pendidikan</h2>

            <textarea name="tujuan" rows="4"
                class="w-full border rounded-lg p-3 text-sm">

            {{ $profil['tujuan'] ?? '' }}

            </textarea>
        </div>


        <!-- LOKASI -->
        <div class="card-modern p-6 mb-6">
            <h2 class="text-lg mb-3">Lokasi TPQ</h2>

            <input type="text"
                name="lokasi"
                value="{{ $profil['lokasi'] ?? '' }}"
                class="w-full border rounded-lg p-3 text-sm">
        </div>


        <!-- FOTO PIMPINAN -->
        <div class="card-modern p-6 mb-6">

            <h2 class="text-lg mb-4">Foto Pimpinan</h2>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">

                <div>
                    <div>
                        @if(!empty($profil['pembina']))
                        <img src="{{ asset('images/pimpinan/'.$profil['pembina']) }}"
                            class="w-20 h-20 rounded-full mb-2 object-cover">
                        <!-- ✨ Tambahkan input Nama pembina -->
                        <input type="text" name="pembina_nama" placeholder="Nama 1"
                            value="{{ $profil['pembina_nama'] ?? '' }}"
                            class="w-full border rounded-lg p-2 text-sm mb-1">

                        <!-- ✨ Tambahkan input Jabatan pembina -->
                        <input type="text" name="pembina_jabatan" placeholder="Jabatan 1"
                            value="{{ $profil['pembina_jabatan'] ?? '' }}"
                            class="w-full border rounded-lg p-2 text-sm">
                        @endif
                        <input type="file" name="pembina" class="mt-1">
                    </div>

                </div>

                <div>
                    @if(!empty($profil['ketua']))
                    <img src="{{ asset('images/pimpinan/'.$profil['ketua']) }}"
                        class="w-20 h-20 rounded-full mb-2 object-cover">
                    <!-- ✨ Tambahkan input Nama ketua -->
                    <input type="text" name="ketua_nama" placeholder="Nama 2"
                        value="{{ $profil['ketua_nama'] ?? '' }}"
                        class="w-full border rounded-lg p-2 text-sm mb-1">

                    <!-- ✨ Tambahkan input Jabatan ketua -->
                    <input type="text" name="ketua_jabatan" placeholder="Jabatan 2"
                        value="{{ $profil['ketua_jabatan'] ?? '' }}"
                        class="w-full border rounded-lg p-2 text-sm">
                    @endif
                    <input type="file" name="ketua" class="mt-1">
                </div>

                <div>
                    @if(!empty($profil['sekretaris']))
                    <img src="{{ asset('images/pimpinan/'.$profil['sekretaris']) }}"
                        class="w-20 h-20 rounded-full mb-2 object-cover">

                    <!-- ✨ Tambahkan input Nama sekretaris -->
                    <input type="text" name="sekretaris_nama" placeholder="Nama 3"
                        value="{{ $profil['sekretaris_nama'] ?? '' }}"
                        class="w-full border rounded-lg p-2 text-sm mb-1">

                    <!-- ✨ Tambahkan input Jabatan sekretaris -->
                    <input type="text" name="sekretaris_jabatan" placeholder="Jabatan 3"
                        value="{{ $profil['sekretaris_jabatan'] ?? '' }}"
                        class="w-full border rounded-lg p-2 text-sm">
                    @endif
                    <input type="file" name="sekretaris" class="mt-1">
                </div>

                <div>
                    @if(!empty($profil['bendahara']))
                    <img src="{{ asset('images/pimpinan/'.$profil['bendahara']) }}"
                        class="w-20 h-20 rounded-full mb-2 object-cover">
                    <!-- ✨ Tambahkan input Nama bendahara -->
                    <input type="text" name="bendahara_nama" placeholder="Nama 4"
                        value="{{ $profil['bendahara_nama'] ?? '' }}"
                        class="w-full border rounded-lg p-2 text-sm mb-1">

                    <!-- ✨ Tambahkan input Jabatan bendahara -->
                    <input type="text" name="bendahara_jabatan" placeholder="Jabatan 4"
                        value="{{ $profil['bendahara_jabatan'] ?? '' }}"
                        class="w-full border rounded-lg p-2 text-sm">
                    @endif
                    <input type="file" name="bendahara" class="mt-1">
                </div>

                <div>
                    @if(!empty($profil['staf1']))
                    <img src="{{ asset('images/pimpinan/'.$profil['staf1']) }}"
                        class="w-20 h-20 rounded-full mb-2 object-cover">
                    <!-- ✨ Tambahkan input Nama staf1 -->
                    <input type="text" name="staf1_nama" placeholder="Nama 5"
                        value="{{ $profil['staf1_nama'] ?? '' }}"
                        class="w-full border rounded-lg p-2 text-sm mb-1">

                    <!-- ✨ Tambahkan input Jabatan staf1 -->
                    <input type="text" name="staf1_jabatan" placeholder="Jabatan 5"
                        value="{{ $profil['staf1_jabatan'] ?? '' }}"
                        class="w-full border rounded-lg p-2 text-sm">
                    @endif
                    <input type="file" name="staf1" class="mt-1">
                </div>

                <div>
                    @if(!empty($profil['staf2']))
                    <img src="{{ asset('images/pimpinan/'.$profil['staf2']) }}"
                        class="w-20 h-20 rounded-full mb-2 object-cover">
                    <!-- ✨ Tambahkan input Nama staf2 -->
                    <input type="text" name="staf2_nama" placeholder="Nama 6"
                        value="{{ $profil['staf2_nama'] ?? '' }}"
                        class="w-full border rounded-lg p-2 text-sm mb-1">

                    <!-- ✨ Tambahkan input Jabatan staf2 -->
                    <input type="text" name="staf2_jabatan" placeholder="Jabatan 6"
                        value="{{ $profil['staf2_jabatan'] ?? '' }}"
                        class="w-full border rounded-lg p-2 text-sm">
                    @endif
                    <input type="file" name="staf2" class="mt-1">
                </div>

            </div>

        </div>


        <button
            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Simpan Perubahan
        </button>

    </form>

</div>

@endsection