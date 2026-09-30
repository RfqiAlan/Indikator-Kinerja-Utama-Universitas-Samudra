<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IKU UNSAM') }} - Login</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=2" type="image/x-icon"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-theme-script />
</head>
<body class="font-[Inter] antialiased bg-[#f4f9fd] text-slate-800">
    <div class="min-h-screen flex">
        
        <!-- Left Side: Branding (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-600 to-sky-400 p-12 flex-col relative overflow-hidden">
            <!-- Decorative overlay -->
            <div class="absolute inset-0 bg-black/5"></div>
            
            <div class="relative z-10 flex-1 flex flex-col justify-center">
                <h1 class="text-white text-5xl font-extrabold leading-[1.15] tracking-tight mb-6 max-w-lg">
                    Sistem Manajemen Indikator Kinerja Utama (IKU)
                </h1>
                
                <div class="border-l-4 border-white/50 pl-4 py-1 mb-16">
                    <p class="text-white/90 text-lg font-medium">Transformasi Pendidikan Tinggi, Sains, dan Teknologi</p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-white/20 border border-white/30 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                        </div>
                        <p class="text-white font-medium">Pemantauan Capaian IKU Real-time</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-white/20 border border-white/30 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                        </div>
                        <p class="text-white font-medium">Integrasi Data Perguruan Tinggi Nasional</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-white/20 border border-white/30 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                        </div>
                        <p class="text-white font-medium">Pelaporan Kinerja Berbasis Bukti</p>
                    </div>
                </div>
            </div>

            <div class="relative z-10 mt-auto">
                <p class="text-white/60 text-xs">
                    &copy; {{ date('Y') }} Kementerian Pendidikan Tinggi, Sains, dan Teknologi Republik Indonesia.<br>
                    Seluruh hak cipta dilindungi undang-undang.
                </p>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 sm:p-12 relative">
            
            <div class="w-full max-w-md z-10">
                <!-- Logos -->
                <div class="flex items-center justify-center gap-6 mb-8 w-full">
                    <!-- Kemdikbud Logo -->
                    <div class="flex items-center">
                    <img src="{{ asset('build/assets/logo_kementrian_baru.webp') }}" alt="Logo Kementerian" class="h-10 object-contain">
                    </div>
                    <div class="w-px h-8 bg-slate-300"></div>
                    <!-- Universitas Samudra Logo -->
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('build/assets/logo.png') }}" alt="Logo Unsam" class="w-11 h-11 object-contain">
                        <div class="text-[12px] font-extrabold text-slate-900 leading-tight">
                            Universitas<br>Samudra
                        </div>
                    </div>
                </div>

                <!-- Login Card -->
                <div class="w-full bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-8 sm:p-10 border border-slate-100">
                
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight mb-2">Selamat Datang</h2>
                <p class="text-sm text-slate-500 mb-8 font-medium">Silakan masuk untuk mengakses Sistem Manajemen IKU.</p>

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Alamat Email <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="user@unsam.ac.id" class="block w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder:text-slate-400">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div x-data="{ showPassword: false }">
                        <label for="password" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Kata Sandi <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input id="password" x-bind:type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="••••••••" class="block w-full pl-11 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder:text-slate-400">
                            <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-blue-500 focus:outline-none" @click="showPassword = !showPassword">
                                <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg x-show="showPassword" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mt-6">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                            <div class="relative flex items-center">
                                <input id="remember_me" type="checkbox" class="peer h-5 w-5 cursor-pointer appearance-none rounded border border-slate-300 bg-white checked:border-blue-500 checked:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all" name="remember">
                                <svg class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 h-3.5 w-3.5 text-white opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="ml-3 text-[13px] font-semibold text-slate-600 group-hover:text-slate-800 transition-colors">Ingat saya</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[13px] font-bold text-blue-600 hover:text-blue-700 transition-colors">
                                Lupa kata sandi?
                            </a>
                        @endif
                    </div>

                    <!-- Captcha if applicable -->
                    @if (isset($showCaptcha) && $showCaptcha)
                        <div class="mt-4 flex justify-center">
                            <div class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}"></div>
                            <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2" />
                        </div>
                    @endif

                    <div class="pt-2">
                        <button type="submit" class="w-full flex items-center justify-center py-3.5 px-4 bg-[#338be5] hover:bg-blue-600 text-white text-sm font-bold rounded-xl transition-all shadow-[0_4px_12px_rgba(59,130,246,0.3)] hover:shadow-[0_6px_16px_rgba(59,130,246,0.4)] hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            MASUK KE SISTEM
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @if (isset($showCaptcha) && $showCaptcha)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
</body>
</html>
