<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login Admin - {{ config('app.name', 'Rohis Darul Muttaqin') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }

            @keyframes float1 {
                0%, 100% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(60px, -60px) scale(1.15); }
                66% { transform: translate(-40px, 30px) scale(0.95); }
            }
            @keyframes float2 {
                0%, 100% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(-70px, 50px) scale(0.9); }
                66% { transform: translate(50px, -40px) scale(1.1); }
            }
            @keyframes float3 {
                0%, 100% { transform: translate(0px, 0px) scale(1); }
                50% { transform: translate(40px, 40px) scale(1.2); }
            }

            .animate-blob-1 { animation: float1 14s infinite ease-in-out; }
            .animate-blob-2 { animation: float2 18s infinite ease-in-out; }
            .animate-blob-3 { animation: float3 22s infinite ease-in-out; }
        </style>
    </head>
    <body class="min-h-screen overflow-x-hidden bg-slate-950 text-slate-800 antialiased selection:bg-emerald-500 selection:text-white flex items-center justify-center p-4">
        <!-- Animated Background Orbs -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
            <!-- Background mesh dark gradient -->
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-slate-900 via-slate-950 to-black"></div>

            <!-- Glowing animated color blobs -->
            <div class="animate-blob-1 absolute -left-20 -top-20 h-96 w-96 rounded-full bg-emerald-500/25 blur-[120px]"></div>
            <div class="animate-blob-2 absolute -right-20 top-1/4 h-96 w-96 rounded-full bg-teal-400/25 blur-[130px]"></div>
            <div class="animate-blob-3 absolute bottom-0 left-1/3 h-[30rem] w-[30rem] rounded-full bg-emerald-600/20 blur-[140px]"></div>
            <div class="animate-blob-1 absolute right-1/4 -bottom-20 h-80 w-80 rounded-full bg-lime-400/15 blur-[100px]"></div>

            <!-- Geometric grid overlay -->
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#10b9810f_1px,transparent_1px),linear-gradient(to_bottom,#10b9810f_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_50%,#000_70%,transparent_100%)]"></div>
        </div>

        <div class="relative z-10 w-full max-w-md my-8">
            <!-- Header Logo & Brand Info -->
            <div class="text-center mb-8 space-y-3">
                <a href="{{ route('home') }}" class="inline-block group">
                    <div class="relative inline-flex items-center justify-center p-1.5 rounded-full bg-gradient-to-tr from-emerald-400 via-teal-300 to-emerald-600 shadow-xl shadow-emerald-950/50 transition duration-300 group-hover:scale-105">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Rohis Darul Muttaqin" class="h-20 w-20 rounded-full object-cover bg-white p-0.5 shadow-inner">
                    </div>
                </a>
                <div>
                    <h1 class="text-2xl font-black tracking-tight text-white sm:text-3xl">
                        Rohis Darul Muttaqin
                    </h1>
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-emerald-400 mt-1">
                        Portal Admin & Pengurus
                    </p>
                </div>
            </div>

            <!-- Card Container -->
            <div class="overflow-hidden rounded-[2.5rem] border border-white/10 bg-white/95 p-8 shadow-[0_25px_70px_rgba(6,78,59,0.3)] backdrop-blur-2xl sm:p-10">
                {{ $slot }}
            </div>

            <!-- Footer Link back to homepage -->
            <div class="text-center mt-6">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-400 hover:text-emerald-400 transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Halaman Utama
                </a>
            </div>
        </div>
    </body>
</html>
