<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- WAJIB -->
    <title>TPQ Khairunissa</title>
    @vite('resources/css/app.css')
    {{-- Font Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;600&display=swap" rel="stylesheet">
    @stack('styles')

    <style>
        /* === TAMBAHAN MODERN UI === */

        /* CARD */
        .card-modern {
            border-radius: 16px;
            background: white;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            transition: all 0.25s ease;
        }

        .card-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        /* BUTTON */
        .btn-modern {
            border-radius: 12px;
            padding: 6px 14px;
            font-size: 12px;
            transition: all 0.2s ease;
        }

        .btn-modern:hover {
            transform: scale(1.05);
        }

        /* TABLE */
        table tbody tr:hover {
            background: rgba(59, 130, 246, 0.05);
            transform: scale(1.002);
        }

        /* SIDEBAR ENHANCE */
        .menu-item:hover {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.3), transparent);
            transform: translateX(3px);
        }

        /* ACTIVE MENU */
        .menu-active {
            box-shadow: inset 0 0 8px rgba(59, 130, 246, 0.3);
        }

        [x-cloak] {
            display: none;
        }

        /* SCROLL SIDEBAR MODERN */
        nav::-webkit-scrollbar {
            width: 6px;
        }

        nav::-webkit-scrollbar-track {
            background: transparent;
        }

        nav::-webkit-scrollbar-thumb {
            background: linear-gradient(#2563eb, #1e40af);
            border-radius: 10px;
        }

        nav::-webkit-scrollbar-thumb:hover {
            background: hsl(195, 85%, 60%);
        }

        .menu-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 14px;
            margin: 3px 10px;
            border-radius: 12px;
            transition: .2s ease;
            font-weight: 200;
            letter-spacing: .2px;
            position: relative;
        }

        .menu-item:hover {
            background: #4f52f0;
        }

        .menu-active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.25), transparent);
            border-left: 3px solid #3b82f6;
            color: #93c5fd;
        }

        .submenu {
            display: block;
            padding: 7px 14px;
            margin: 3px 12px;
            font-size: 12.5px;
            color: #cbd5f5;
            border-radius: 12px;
            transition: .2s ease;
            font-weight: 200;
        }

        .submenu:hover {
            background: rgb(30, 67, 151);
        }

        .submenu-active {
            background: #0b328c;
            color: #4ade80;
        }

        /* Tooltip untuk collapsed */
        .tooltip-wrap {
            position: relative;
        }

        .tooltip-wrap .tooltip-text {
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: #0f172a;
            color: #fff;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: 0.2s;
            z-index: 50;
        }

        .tooltip-wrap:hover .tooltip-text {
            opacity: 1;
        }
    </style>
</head>

<body class="bg-white text-slate-800 font-extralight" x-data="{ sidebarOpen:false, collapsed:false }">
    @php
    $user = auth()->user();
    @endphp
    <div class="flex min-h-screen">
        <!-- SIDEBAR -->
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            :style="collapsed ? 'width:4.3rem' : 'width:15rem'"
            class="fixed z-30 inset-y-0 left-0 shadow-2xl
            bg-gradient-to-b from-slate-900 via-blue-950 to-slate-950 
            text-slate-200 overflow-y-auto transform transition-all duration-300 
            md:translate-x-0 flex flex-col">

            <!-- HEADER -->
            <div class="p-4 flex items-center justify-center gap-2 border-b border-slate-800">

                <!-- Logo -->
                <img src="{{ asset('images/logo-tpq.png') }}"
                    class="h-10 w-10 rounded-full object-cover">
                <!-- Text hanya muncul saat tidak collapsed -->
                <span x-show="!collapsed"
                    class="text-[18px] tracking-wide text-sky-300 font-semibold">
                    TPQ Khairunissa
                </span>
            </div>

            <!-- USER (Admin) -->

            <!-- MENU -->
            <nav class="flex-1 overflow-y-auto overflow-x-hidden text-[13px] mt-2 pb-3">

                <!-- DASHBOARD -->
                <a href="/dashboard" class="menu-item tooltip-wrap {{ request()->routeIs('dashboard') ? 'menu-active' : '' }}">
                    <span class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 9.75L12 4.5l9 5.25M4.5 10.5V19.5a.75.75 0 00.75.75h4.5V15a.75.75 0 01.75-.75h3a.75.75 0 01.75.75v5.25h4.5a.75.75 0 00.75-.75V10.5" />
                        </svg>
                        <span x-show="!collapsed">Dashboard</span>
                    </span>
                    <span x-show="collapsed" class="tooltip-text">Dashboard</span>
                </a>

                <!-- PENDAFTARAN -->
                @if(in_array($user->role,['super_admin','admin','pendaftaran','viewer']))
                <div x-data="{ show: {{ request()->routeIs('pendaftaran-santri*','pendaftaran-guru*') ? 'true' : 'false' }} }" class="tooltip-wrap">

                    <button @click="show=!show" class="menu-item w-full justify-between {{ request()->routeIs('pendaftaran-santri*','pendaftaran-guru*') ? 'menu-active' : '' }}">
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 100-8 4 4 0 000 8zM6 20a6 6 0 0112 0" />
                            </svg>
                            <span x-show="!collapsed">Pendaftaran</span>
                        </span>
                        <span x-show="!collapsed">▾</span>
                    </button>
                    <div x-show="show && !collapsed" class="ml-6 mt-1 space-y-1">
                        <a href="{{ route('pendaftaran-santri.index') }}" class="submenu">Form Pendaftaran Santri</a>
                        <a href="{{ route('pendaftaran-guru.index') }}" class="submenu">Form Pendaftaran Guru</a>
                    </div>
                    <div x-show="collapsed" class="tooltip-text">Pendaftaran</div>
                </div>
                @endif

                <!-- DATA SANTRI -->
                <div x-data="{ show: {{ request()->routeIs('santri*','gender-usia*','status*') ? 'true' : 'false' }} }" class="tooltip-wrap">
                    <button @click="show=!show" class="menu-item w-full justify-between {{ request()->routeIs('santri*','gender-usia*','status*') ? 'menu-active' : '' }}">
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9 9 0 1118.879 6.196" />
                            </svg>
                            <span x-show="!collapsed" class="flex items-center gap-2">
                                Data Santri
                                <span class="ml-auto bg-blue-600 text-white text-[10px] px-2 py-0.5 rounded-full">
                                    {{ $sidebarCounts['santri'] ?? 0 }}
                                </span>
                            </span>
                        </span>
                        <span x-show="!collapsed">▾</span>
                    </button>
                    <div x-show="show && !collapsed" class="ml-6 mt-1 space-y-1">
                        @if(in_array($user->role,['super_admin','admin','viewer']))
                        <a href="/santri" class="submenu">Nama Santri</a>
                        @endif

                        @if(in_array($user->role,['super_admin','admin','viewer']))
                        <a href="/gender-usia" class="submenu">Gender & Usia</a>
                        @endif


                        <a href="{{ route('status.index') }}" class="submenu">Status Santri</a>

                    </div>

                    <!-- DATA GURU -->
                    @if(in_array($user->role,['super_admin','admin','viewer']))
                    <div x-data="{ show: {{ request()->routeIs('guru*') ? 'true' : 'false' }} }" class="tooltip-wrap">
                        <button @click="show=!show" class="menu-item w-full justify-between {{ request()->routeIs('guru*') ? 'menu-active' : '' }}">
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422L21 14l-9 5-9-5 1.84-3.422L12 14z" />
                                </svg>
                                <span x-show="!collapsed" class="flex items-center gap-2">
                                    Data Guru
                                    <span class="ml-auto bg-emerald-600 text-white text-[10px] px-2 py-0.5 rounded-full">
                                        {{ $sidebarCounts['guru'] ?? 0 }}
                                    </span>
                                </span>
                            </span>
                            <span x-show="!collapsed">▾</span>
                        </button>
                        <div x-show="show && !collapsed" class="ml-6 mt-1 space-y-1">
                            <a href="{{ route('guru.index') }}" class="submenu">Nama Guru</a>
                            <a href="{{ route('guru-kelahiran-usia.index') }}" class="submenu">Gender & Usia</a>
                            <a href="{{ route('guru.alamat-kontak') }}" class="submenu">Alamat Kontak</a>
                            <a href="{{ route('guru.pendidikan') }}" class="submenu">Pendidikan</a>
                            <a href="{{ route('guru.status') }}" class="submenu">Status Kehadiran Guru</a>
                        </div>
                        <div x-show="collapsed" class="tooltip-text">Data Guru</div>
                    </div>
                    @endif

                    <!-- DATA ORANGTUA -->
                    <div x-data="{ show: {{ request()->routeIs('orangtua*') ? 'true' : 'false' }} }" class="tooltip-wrap">
                        <button @click="show=!show" class="menu-item w-full justify-between {{ request()->routeIs('orangtua*') ? 'menu-active' : '' }}">
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                <span x-show="!collapsed" class="flex items-center gap-2">
                                    Data Orang Tua
                                    <span class="ml-auto bg-purple-600 text-white text-[10px] px-2 py-0.5 rounded-full">
                                        {{ $sidebarCounts['orangtua'] ?? 0 }}
                                    </span>
                                </span>
                            </span>
                            <span x-show="!collapsed">▾</span>
                        </button>
                        <div x-show="show && !collapsed" class="ml-6 mt-1 space-y-1">
                            @if(in_array($user->role,['super_admin','admin','viewer']))
                            <a href="/orangtua" class="submenu">Nama + Status Orangtua</a>
                            <a href="{{ route('orangtua.pekerjaan') }}" class="submenu">Pekerjaan Orang Tua</a>
                            @endif
                            <a href="{{ route('orangtua.alamat-kontak') }}" class="submenu">Alamat & Kontak</a>
                        </div>

                        <!-- RELASI DATA -->
                        <div x-data="{ show: {{ request()->routeIs('relasi*') ? 'true' : 'false' }} }" class="tooltip-wrap">
                            <button @click="show=!show" class="menu-item w-full justify-between {{ request()->routeIs('relasi*') ? 'menu-active' : '' }}">
                                <span class="flex items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h8m-8 4h6" />
                                    </svg>
                                    <span x-show="!collapsed">Relasi Data</span>
                                </span>
                                <span x-show="!collapsed">▾</span>
                            </button>
                            <div x-show="show && !collapsed" class="ml-6 mt-1 space-y-1">
                                <a href="/relasi/santri-guru" class="submenu">Santri + Guru</a>
                                @if(in_array($user->role,['super_admin','admin','pendaftaran','viewer']))
                                <a href="/relasi/santri-orangtua" class="submenu">Santri + Orang Tua</a>
                                @endif
                            </div>
                            <div x-show="collapsed" class="tooltip-text">Relasi Data</div>
                        </div>

                        <!-- LAPORAN -->
                        @if(in_array($user->role,['super_admin','admin','guru','viewer']))
                        <div x-data="{ show: {{ request()->routeIs('laporan*') ? 'true' : 'false' }} }" class="tooltip-wrap">
                            <button @click="show=!show" class="menu-item w-full justify-between {{ request()->routeIs('laporan*') ? 'menu-active' : '' }}">
                                <span class="flex items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6h13M9 11H4v10h13v-6H9" />
                                    </svg>
                                    <span x-show="!collapsed">Laporan Progres</span>
                                </span>
                                <span x-show="!collapsed">▾</span>
                            </button>
                            <div x-show="show && !collapsed" class="ml-6 mt-1 space-y-1">
                                <a href="{{ route('laporan.progres-iqra') }}" class="submenu">Progres Iqra</a>
                                <a href="{{ route('laporan.progres-alquran') }}" class="submenu">Progres Al Quran</a>
                                <a href="#" class="submenu">Progres Hafalan</a>
                            </div>
                            <div x-show="collapsed" class="tooltip-text">Laporan</div>
                        </div>
                        @endif

                        <!-- INFORMASI -->

                        <div x-data="{ show: {{ request()->routeIs('informasi*') ? 'true' : 'false' }} }" class="tooltip-wrap">
                            <button @click="show=!show" class="menu-item w-full justify-between {{ request()->routeIs('informasi*') ? 'menu-active' : '' }}">
                                <span class="flex items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 12h.01M12 12h.01M12 12h.01" />
                                    </svg>
                                    <span x-show="!collapsed" class="flex items-center gap-2">
                                        Informasi
                                        <span class="ml-auto bg-orange-600 text-white text-[10px] px-2 py-0.5 rounded-full">
                                            {{ $sidebarCounts['berita'] ?? 0 }}
                                        </span>
                                    </span>
                                </span>
                                <span x-show="!collapsed">▾</span>
                            </button>
                            <div x-show="show && !collapsed" class="ml-6 mt-1 space-y-1">
                                @if(in_array($user->role,['super_admin','admin','guru','viewer']))
                                <a href="{{ route('berita.index') }}" class="submenu">Berita</a>
                                <a href="{{ route('pengumuman.index') }}" class="submenu">Pengumuman</a>
                                @endif

                                <a href="{{ route('informasi.jadwal.index') }}" class="submenu">Jadwal Belajar</a>
                                <!-- ✅ TAMBAHAN -->

                                @if(in_array($user->role,['super_admin','admin']))
                                <a href="/galeri" class="submenu">Galeri</a>
                                @endif

                                @if(in_array($user->role,['super_admin','admin']))
                                <a href="{{ route('admin.profil') }}"
                                    class="submenu {{ request()->routeIs('admin.profil') ? 'submenu-active' : '' }}">
                                    Profil Website
                                </a>
                                @endif

                                @if(in_array($user->role,['super_admin','admin']))
                                <a href="/admin/kontak" class="submenu 
                                {{ request()->is('admin/kontak*') ? 'submenu-active' : '' }}">
                                    Kontak
                                </a>



                                @endif
                            </div>


                            <!-- PENGATURAN -->
                            @if($user->role == 'super_admin')
                            <div x-data="{ show: {{ request()->routeIs('pengaturan*') ? 'true' : 'false' }} }" class="tooltip-wrap">
                                <button @click="show=!show" class="menu-item w-full justify-between {{ request()->routeIs('pengaturan*') ? 'menu-active' : '' }}">
                                    <span class="flex items-center gap-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                                            <circle cx="12" cy="12" r="10" />
                                        </svg>
                                        <span x-show="!collapsed">Pengaturan</span>
                                    </span>
                                    <span x-show="!collapsed">▾</span>
                                </button>
                                <div x-show="show && !collapsed" class="ml-6 mt-1 space-y-1">
                                    <a href="#" class="submenu">Hak Akses</a>
                                    <a href="#" class="submenu">Lainnya (nanti)</a>
                                </div>
                                <div x-show="collapsed" class="tooltip-text">Pengaturan</div>
                            </div>
                            @endif

                            <!-- ADMIN / LOGOUT -->
                            <div class="px-4 py-2 border-t border-slate-400" x-show="!collapsed">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="menu-item w-full justify-center bg-slate-600 text-white">Logout</button>
                                </form>
                            </div>
            </nav>
        </aside>

        <!-- CONTENT -->
        <div class="flex-1 flex flex-col ml-0 transition-all duration-300"
            :class="collapsed ? 'md:ml-[4.3rem]' : 'md:ml-[15rem]'">
            <!-- TOPBAR -->
            <nav
                :class="collapsed ? 'md:left-[4.3rem]' : 'md:left-[15rem]'"
                class="fixed top-0 right-0 left-0
                z-40 h-14
                bg-white/60 backdrop-blur-xl
                border-b border-slate-200/60
                flex items-center justify-between px-4 lg:px-6
                shadow-sm
                transition-all duration-300">

                <!-- LEFT SIDE -->
                <div class="flex items-center gap-3">
                    <button @click="window.innerWidth < 768 ? sidebarOpen = !sidebarOpen : collapsed = !collapsed"
                        class="p-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-100 transition shadow-sm"
                        aria-label="Toggle Sidebar">
                        <svg class="w-7 h-7 text-slate-900" fill="none" stroke="currentColor" stroke-width="2.4"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <span class="text-slate-900 font-extralight tracking-wide">
                        Sistem Informasi TPQ
                    </span>
                </div>

                <!-- SEARCH SANTRI DI NAVBAR-->
                <div class="hidden lg:flex items-center w-64">
                    <div class="relative">
                        <svg class="absolute left-3 top-2.5 w-4 h-4 text-slate-400"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m1.85-5.65a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
                        </svg>
                        <input
                            type="text"
                            placeholder="Cari santri..."
                            class="w-full pl-10 pr-4 py-2 text-sm 
                            bg-white/60 backdrop-blur-md
                            border border-slate-300
                            rounded-full
                            outline-none
                            focus:ring-2 focus:ring-blue-400/40
                            focus:border-blue-400
                            transition
                            placeholder:text-slate-400">
                    </div>
                </div>

                <!-- RIGHT SIDE (ADMIN PROFILE PINDAHAN) -->
                <div class="flex items-center gap-3 relative shrink-0" x-data="{open:false}"
                    @keydown.escape.window="open=false">
                    <div class="text-right leading-tight">
                        <p class="text-sm font-medium text-slate-700">
                            @if(Auth::user()->email == 'admin@tpq.com')
                            Admin TPQ
                            @elseif(Auth::user()->email == 'guru@tpq.com')
                            Guru TPQ
                            @elseif(Auth::user()->email == 'daftar@tpq.com')
                            Daftar TPQ
                            @else
                            User TPQ
                            @endif
                        </p>
                        <p class="text-[11px] text-emerald-500">● Online</p>
                    </div>

                    <!-- NOTIFICATION BELL 🔔 DI NAVBAR -->
                    <div class="relative" x-data="{notif:false}" @keydown.escape.window="notif=false">

                        <!-- BUTTON -->
                        <button
                            @click="notif=!notif"
                            class="relative p-2 rounded-lg hover:bg-slate-100 transition">

                            🔔

                            <span class="absolute -top-1 -right-1 
        bg-red-500 text-white text-[10px] 
        w-4 h-4 flex items-center justify-center rounded-full">
                                3
                            </span>

                        </button>

                        <!-- DROPDOWN -->
                        <div
                            x-show="notif"
                            x-cloak
                            x-transition
                            @click.outside="notif=false"
                            class="absolute right-0 top-10 w-64 bg-white shadow-xl 
                            rounded-xl border border-slate-200 text-sm py-2">

                            <!-- TITLE -->
                            <div class="px-3 pb-2 border-b border-slate-100">
                                <p class="font-semibold text-slate-700">
                                    Notifikasi
                                </p>
                            </div>

                            <!-- ITEM -->
                            <a href="/santri"
                                @click="notif=false"
                                class="block px-3 py-2 hover:bg-slate-50 text-xs text-slate-600">
                                📢 Santri baru mendaftar
                            </a>

                            <a href="/jadwal"
                                @click="notif=false"
                                class="block px-3 py-2 hover:bg-slate-50 text-xs text-slate-600">
                                📅 Jadwal mengaji hari ini
                            </a>

                            <a href="/pengumuman"
                                @click="notif=false"
                                class="block px-3 py-2 hover:bg-slate-50 text-xs text-slate-600">
                                📌 Pengumuman TPQ
                            </a>

                            <!-- FOOTER -->
                            <div class="border-t border-slate-100 mt-1">
                                <a href="/notifikasi"
                                    @click="notif=false"
                                    class="block text-center text-xs py-2 text-blue-600 hover:bg-slate-50">
                                    Lihat semua notifikasi
                                </a>
                            </div>

                        </div>

                    </div>

                    <!-- AVATAR -->
                    <img
                        @click="open=!open"
                        class="w-9 h-9 rounded-full ring-2 ring-blue-400/40 cursor-pointer 
                        hover:scale-110 transition duration-200"
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}
        @if(Auth::user()->email == 'admin@tpq.com')
        &background=2563eb
        @elseif(Auth::user()->email == 'guru@tpq.com')
        &background=16a34a
        @elseif(Auth::user()->email == 'daftar@tpq.com')
        &background=f59e0b
        @else
        &background=64748b
        @endif
        &color=fff&bold=true">

                    <!-- DROPDOWN MENU -->
                    <div x-show="open"
                        @click.outside="open=false"
                        x-transition
                        x-cloak
                        class="absolute right-0 top-12 w-44 bg-white rounded-xl shadow-lg border border-slate-200 py-2 text-sm z-50">

                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 hover:bg-slate-100">
                            👤 Profil Saya
                        </a>

                        <a href="{{ route('password.request') }}"
                            class="block px-4 py-2 hover:bg-slate-100">
                            🔑 Ganti Password
                        </a>

                        <hr class="my-1">

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 hover:bg-red-50 text-red-600">
                                🚪 Logout
                            </button>
                        </form>

                    </div>
                </div>
            </nav>

            <!-- MAIN -->
            <main class="px-6 pb-6 pt-20 transition-all duration-300">
                @yield('content')
            </main>
        </div>
    </div>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>

</html>