<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans text-gray-900 antialiased bg-gradient-to-br from-indigo-300 via-purple-300 to-pink-300 min-h-screen relative overflow-x-hidden flex flex-col">

    <div
        class="absolute top-0 -left-4 w-72 h-72 bg-purple-400 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-blob">
    </div>
    <div
        class="absolute top-0 -right-4 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-blob animation-delay-2000">
    </div>
    <div
        class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-400 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-blob animation-delay-4000">
    </div>

    <div class="relative z-10 flex-grow flex flex-col">
        <nav
            class="w-full p-6 flex flex-col sm:flex-row justify-between items-center bg-white/30 backdrop-blur-md border-b border-white/40 shadow-sm gap-4 sm:gap-0">
            <div class="flex items-center gap-2">
                <svg class="w-8 h-8 text-indigo-600 drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M19 3H5c-1.1 0-1.99.9-1.99 2L3 19c0 1.1.89 2 1.99 2H19c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 11h-4v4h-4v-4H6v-4h4V6h4v4h4v4z" />
                </svg>
                <span class="text-2xl font-bold text-gray-800 drop-shadow-sm tracking-tight">MediConnect</span>
            </div>

            @if (Route::has('login'))
                <div class="flex items-center gap-4 flex-wrap justify-center">
                    <div
                        class="flex items-center gap-1 bg-white/40 p-1 rounded-lg backdrop-blur-md border border-white/50 shadow-sm mr-2">
                        <a href="{{ route('lang.switch', 'en') }}"
                            class="px-2 py-1 text-xs font-bold rounded-md transition-colors {{ app()->getLocale() == 'en' ? 'bg-indigo-600 text-white shadow' : 'text-gray-700 hover:bg-white/60' }}">EN</a>
                        <a href="{{ route('lang.switch', 'fr') }}"
                            class="px-2 py-1 text-xs font-bold rounded-md transition-colors {{ app()->getLocale() == 'fr' ? 'bg-indigo-600 text-white shadow' : 'text-gray-700 hover:bg-white/60' }}">FR</a>
                        <a href="{{ route('lang.switch', 'ar') }}"
                            class="px-2 py-1 text-xs font-bold rounded-md transition-colors {{ app()->getLocale() == 'ar' ? 'bg-indigo-600 text-white shadow' : 'text-gray-700 hover:bg-white/60' }}">AR</a>
                    </div>
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-6 py-2.5 bg-white/60 hover:bg-white/80 backdrop-blur-md border border-white/50 text-indigo-700 font-semibold rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                            {{ __('Dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-5 py-2.5 bg-white/40 hover:bg-white/60 backdrop-blur-md border border-white/50 text-gray-800 font-medium rounded-xl shadow-sm transition-all duration-300">
                            {{ __('Log in') }}
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-6 py-2.5 bg-indigo-600/80 hover:bg-indigo-600 backdrop-blur-md border border-indigo-400/50 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                                {{ __('Register') }}
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </nav>

        <main class="flex-grow flex items-center justify-center p-6">
            <div class="max-w-5xl w-full grid md:grid-cols-2 gap-12 items-center">

                <div class="space-y-6 text-center md:text-left z-10">
                    <h1
                        class="text-5xl lg:text-6xl font-extrabold text-gray-900 tracking-tight drop-shadow-sm leading-tight">
                        {{ __('Welcome to MediConnect') }}
                    </h1>
                    <p
                        class="text-lg md:text-xl text-gray-800/90 font-medium drop-shadow-sm max-w-lg mx-auto md:mx-0 leading-relaxed mt-4">
                        {{ __('Your health is our priority. Book appointments with top doctors effortlessly.') }}
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4 pt-6">
                        @if (!Auth::check() && Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-8 py-3.5 bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 text-white font-semibold text-lg rounded-2xl shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-white/20">
                                Get Started
                            </a>
                        @endif
                        <a href="#features"
                            class="px-8 py-3.5 bg-white/40 hover:bg-white/60 backdrop-blur-md border border-white/50 text-indigo-900 font-semibold text-lg rounded-2xl shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            Learn More
                        </a>
                    </div>
                </div>

                <div class="relative hidden md:block">
                    <div
                        class="w-full max-w-md mx-auto aspect-square bg-white/40 backdrop-blur-xl border border-white/50 rounded-[3rem] shadow-2xl p-8 relative overflow-hidden flex flex-col justify-between transform md:rotate-3 hover:rotate-0 transition-all duration-500 hover:shadow-indigo-500/20">
                        <div class="absolute inset-0 border-[3px] border-white/30 rounded-[3rem] pointer-events-none">
                        </div>

                        <div class="flex justify-between items-center border-b border-white/30 pb-4">
                            <div
                                class="w-14 h-14 rounded-full bg-white/50 border border-white/40 flex items-center justify-center shadow-sm">
                                <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="flex gap-2">
                                <div class="w-3 h-3 rounded-full bg-red-400/80 shadow-sm"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-400/80 shadow-sm"></div>
                                <div class="w-3 h-3 rounded-full bg-green-400/80 shadow-sm"></div>
                            </div>
                        </div>

                        <div class="space-y-4 my-6">
                            <div class="h-4 bg-white/60 rounded-full w-3/4 shadow-sm"></div>
                            <div class="h-4 bg-white/50 rounded-full w-1/2 shadow-sm"></div>
                            <div class="h-4 bg-white/40 rounded-full w-5/6 shadow-sm"></div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div
                                class="bg-white/50 backdrop-blur-md rounded-2xl p-4 shadow-sm border border-white/40 text-center transform hover:-translate-y-1 transition-transform">
                                <div class="text-3xl font-extrabold text-indigo-700">12</div>
                                <div class="text-sm font-semibold text-gray-700">Appointments</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-indigo-500/80 to-purple-500/80 backdrop-blur-md rounded-2xl p-4 shadow-md border border-white/30 text-center text-white transform hover:-translate-y-1 transition-transform">
                                <div class="text-3xl font-extrabold">3</div>
                                <div class="text-sm font-semibold text-white/90">New Messages</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>

</html>