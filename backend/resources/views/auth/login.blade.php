 @extends('public.layouts.app')
 @section('content')

 <!-- ORNAMEN ISLAMIC BESAR -->
 <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden">

     <svg class="absolute -top-20 -left-20 w-[600px] opacity-10"
         viewBox="0 0 200 200"
         fill="none"
         xmlns="http://www.w3.org/2000/svg">

         <circle cx="100" cy="100" r="90" stroke="white" stroke-width="2" />

         <path d="M100 10 L120 80 L190 80 L135 120 L155 190 L100 150 L45 190 L65 120 L10 80 L80 80 Z"
             stroke="white"
             stroke-width="2" />

     </svg>

 </div>

 <div class="relative max-w-md mx-auto p-[1px] rounded-2xl 
    bg-gradient-to-br from-white/40 via-white/10 to-blue/30">

     <!-- INNER GLASS -->
     <div class="bg-white/8 backdrop-blur-x1 border border-emerald/30 rounded-2xl shadow-4x3 p-8">

         <div class="text-center mb-6">
             <h2 class="text-3xl font-bold text-white">Assalamu'alaikum</h2>
             <p class="text-white/80 mt-2">Masuk untuk melanjutkan ke dashboard TPQ</p>
         </div>

         <!-- Session Status -->
         <x-auth-session-status class="mb-4" :status="session('status')" />

         <form method="POST" action="{{ route('login') }}" class="space-y-3">
             @csrf

             <!-- Email -->
             <div class="text-center mb-6">
                 <label class="block text-sm text-white/90">Email</label>
                 <input type="email" name="email" required
                     class="mt-1 text-center px-8 py-2 bg-white/20 border border-white/30 rounded-lg text-white placeholder-white/50 focus:ring-2 focus:ring-blue-300 focus:outline-none"
                     placeholder="email@tpq.com">
             </div>

             <!-- Password -->
             <div class="text-center mb-6">
                 <label class="block text-sm text-white/90">Password</label>
                 <input type="password" name="password" required
                     class="mt-1 text-center px-8 py-2 bg-white/20 border border-white/30 rounded-lg text-white placeholder-white/50 focus:ring-2 focus:ring-blue-300 focus:outline-none"
                     placeholder="********">
             </div>

             <!-- Remember -->
             <div class="flex items-center justify-center space-x-6">
                 <label class="flex items-center space-x-2 text-white/90">
                     <input type="checkbox" name="remember"
                         class="h-4 w-4 text-blue-400 border-white/30 rounded">
                     <span class="text-sm">Ingat saya</span>
                 </label>

                 <a href="{{ route('password.request') }}"
                     class="text-sm text-white/80 hover:text-white hover:underline">
                     Lupa password?
                 </a>
             </div>

             <!-- Button -->
             <div class="text-center mt-6">
                 <button type="submit"
                     class="py-3 px-8 bg-gradient-to-r from-blue-500 to-blue-700 text-white font-semibold rounded-lg shadow-lg hover:scale-105 hover:from-blue-600 hover:to-blue-800 transition-all">
                     Masuk
                 </button>

                 <p class="mt-6 text-sm text-white/80">
                     Belum punya akun?
                     <a href="{{ route('register') }}"
                         class="text-white hover:underline font-medium">
                         Daftar sekarang
                     </a>
                 </p>
             </div>
         </form>

     </div>
 </div>

 @endsection