<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        @if(Auth::check() && request()->routeIs('admin.*'))
            @php
                // Di sinilah menu Pengumuman ditambahkan
                $adminNavItems = [
                    ['label' => 'Dashboard', 'route' => route('admin.dashboard'), 'active' => request()->routeIs('admin.dashboard')],
                    ['label' => 'Pendaftaran', 'route' => route('admin.registrations.index'), 'active' => request()->routeIs('admin.registrations.*')],
                    ['label' => 'Pengurus', 'route' => route('admin.officers.index'), 'active' => request()->routeIs('admin.officers.*')],
                    ['label' => 'Dokumentasi', 'route' => route('admin.schedules.index'), 'active' => request()->routeIs('admin.schedules.*')],
                    ['label' => 'Pengumuman', 'route' => route('admin.announcements.index'), 'active' => request()->routeIs('admin.announcements.*')],
                    ['label' => 'Foto Hero', 'route' => route('admin.settings.index'), 'active' => request()->routeIs('admin.settings.*')],
                    ['label' => 'Absensi Piket', 'route' => route('admin.piket.index'), 'active' => request()->routeIs('admin.piket.*')],
                    ['label' => 'Kas & Infaq', 'route' => route('admin.kas.index'), 'active' => request()->routeIs('admin.kas.*')],
                    ['label' => 'Teks Beranda', 'route' => route('admin.texts.index'), 'active' => request()->routeIs('admin.texts.*')],
                    ['label' => 'Galeri Kegiatan', 'route' => route('admin.galleries.index'), 'active' => request()->routeIs('admin.galleries.*')],
                ];
            @endphp

            <div class="min-h-screen rohis-admin-shell">
                <div class="mx-auto flex max-w-[1600px] gap-6 p-4 lg:p-6">
                    <aside class="rohis-admin-sidebar hidden w-72 shrink-0 flex-col rounded-[2rem] p-5 lg:flex">
                        <div class="flex items-center gap-3 pb-4 mb-6 border-b border-emerald-100">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo Rohis Darul Muttaqin" class="object-cover rounded-full shadow-lg h-11 w-11 shadow-emerald-600/20">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-700">Admin</p>
                                <h2 class="text-base font-black text-slate-900">Rohis Darul Muttaqin</h2>
                            </div>
                        </div>

                        <nav class="space-y-2">
                            @foreach($adminNavItems as $item)
                                <a href="{{ $item['route'] }}" class="rohis-admin-link flex items-center justify-between {{ $item['active'] ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                                    <span>{{ $item['label'] }}</span>
                                    @if($item['active'])
                                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                    @endif
                                </a>
                            @endforeach
                        </nav>

                        <div class="pt-5 mt-auto space-y-3 border-t border-emerald-100">
                            <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2.5 text-sm font-bold text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-100">
                                <i data-lucide="house" class="w-4 h-4"></i>
                                Website
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-100">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </aside>

                    <div class="flex-1">
                        @include('layouts.navigation')

                        @isset($header)
                            <header class="mb-6 rohis-admin-header">
                                <div class="max-w-full px-4 py-6 mx-auto sm:px-6 lg:px-8">
                                    {{ $header }}
                                </div>
                            </header>
                        @endisset

                        <main class="space-y-6">
                            {{ $slot }}
                        </main>
                    </div>
                </div>
            </div>
        @else
            <div class="min-h-screen bg-slate-100">
                @include('layouts.navigation')

                @isset($header)
                    <header class="bg-white shadow">
                        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main>
                    {{ $slot }}
                </main>
            </div>
        @endif
        <script>lucide.createIcons();</script>
    </body>
</html>