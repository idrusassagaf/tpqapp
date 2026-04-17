<nav class="bg-white shadow-md h-16 flex items-center justify-between px-6 fixed left-64 right-0 top-0 z-20">

    <!-- Brand / Logo -->
    <div class="flex items-center space-x-3">
        <img src="{{ asset('public/images/logo-tpq.jpg') }}" alt="Logo TPQ" class="h-10 w-10 rounded-full shadow-sm">
        <span class="text-xl font-bold text-gray-800">Sistem Informasi TPQ</span>
    </div>

    <!-- Navigation & User -->
    <div class="flex items-center space-x-6">

        <!-- Menu Links -->
        <a href="/"
            class="text-gray-700 font-medium px-4 py-2 rounded hover:bg-indigo-500 hover:text-white transition">
            Home
        </a>
        <a href="/santri"
            class="text-gray-700 font-medium px-4 py-2 rounded hover:bg-indigo-500 hover:text-white transition">
            Data Santri
        </a>
        <a href="/guru"
            class="text-gray-700 font-medium px-4 py-2 rounded hover:bg-indigo-500 hover:text-white transition">
            Data Guru
        </a>

        <!-- User Info -->
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/admin.png') }}" alt="Admin" class="h-8 w-8 rounded-full border border-gray-300">
            <span class="text-gray-700 font-medium">Admin</span>
        </div>

    </div>

</nav>