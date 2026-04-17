<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TPQ Khairunissa</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen w-full bg-gradient-to-br from-blue-500 via-blue-700 to-slate-900 text-white text-sm md:text-base">

    <!-- NAVBAR -->
    <nav class="w-full h-16 bg-gradient-to-r from-blue-500 via-blue-700 to-slate-900 text-white p-4 shadow-lg fixed top-0 left-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-2 md:px-0">
            <h1 class="font-bold text-base md:text-lg truncate">TPQ Khairunissa</h1>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-1">
                <a href="/" class="block py-2 px-3 rounded hover:bg-white/20 transition {{ request()->is('/') ? 'bg-white/20' : '' }}">Home</a>
                <a href="/profil" class="block py-2 px-3 rounded hover:bg-white/20 transition">Profil</a>
                <a href="/jadwal" class="block py-2 px-3 rounded hover:bg-white/20 transition">Jadwal</a>
                <a href="{{ route('berita.public.index') }}" class="block py-2 px-3 rounded hover:bg-white/20 transition">Berita</a>
                <a href="{{ route('pengumuman.public.index') }}" class="block py-2 px-3 rounded hover:bg-white/20 transition">Pengumuman</a>
                <a href="/kontak" class="block py-2 px-3 rounded hover:bg-white/20 transition">Kontak</a>
                {{-- LOGIN / DASHBOARD --}}
                @auth
                <a href="/dashboard"
                    class="ml-2 md:ml-3 px-3 md:px-4 py-1.5 md:py-2 bg-emerald-500 rounded-lg hover:bg-emerald-600 transition">
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}"
                    class="ml-2 md:ml-3 px-3 md:px-4 py-1.5 md:py-2 bg-gradient-to-r from-yellow-400 to-orange-400 text-slate-900 rounded-xl shadow hover:scale-105 transition">
                    🔐 Login
                </a>
                @endauth
            </div>

            <!-- Hamburger Mobile -->
            <div class="md:hidden">
                <button id="hamburgerBtn" class="focus:outline-none">
                    <svg class="w-7 h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden mt-2 mx-2 p-2 rounded-xl bg-white/10 backdrop-blur space-y-1 transition-all duration-300">
            <a href="/" class="block py-2 px-3 rounded hover:bg-white/20 transition {{ request()->is('/') ? 'bg-white/20' : '' }}">Home</a>
            <a href="/profil" class="block py-2 px-3 rounded hover:bg-white/20 transition">Profil</a>
            <a href="/jadwal" class="block py-2 px-3 rounded hover:bg-white/20 transition">Jadwal</a>
            <a href="{{ route('berita.public.index') }}" class="block py-2 px-3 rounded hover:bg-white/20 transition">Berita</a>
            <a href="{{ route('pengumuman.public.index') }}" class="block py-2 px-3 rounded hover:bg-white/20 transition">Pengumuman</a>
            <a href="/kontak" class="block py-2 px-3 rounded hover:bg-white/20 transition">Kontak</a>
            {{-- LOGIN / DASHBOARD --}}
            @auth
            <a href="/dashboard" class="block py-2 px-3 rounded bg-emerald-500 hover:bg-emerald-600 transition">
                Dashboard
            </a>
            @else
            <a href="{{ route('login') }}" class="block py-2 px-3 rounded bg-yellow-400 text-slate-900 hover:bg-yellow-300 transition">
                🔐 Login
            </a>
            @endauth

        </div>
    </nav>

    <!-- CONTENT -->
    <div id="mainContent" class="w-full pt-24 md:pt-28 px-3 md:px-6">
        @yield('content')
    </div>

    <!-- FOOTER -->
    <footer class="bg-slate-800 text-white text-center p-4 mt-10">
        © {{ date('Y') }} TPQ Khairunissa
    </footer>

    <!-- SCRIPT TOGGLE MOBILE MENU -->
    <script>
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        hamburgerBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>

</body>

</html>