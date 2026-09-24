<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Rohis Darul Muttaqin - Organisasi Kerohanian Islam' }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Assets Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    @stack('styles')
</head>
<body class="min-h-screen bg-islamic-pattern text-slate-800 antialiased flex flex-col justify-between selection:bg-emerald-600 selection:text-white" x-data="{ mobileMenuOpen: false }">

    <!-- MAIN HEADER NAVBAR -->
    <header class="sticky top-0 z-50 border-b border-slate-200/90 bg-white/95 backdrop-blur-xl shadow-xs transition-all duration-200">
        <div class="max-w-7xl mx-auto px-3.5 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <!-- Brand / Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group focus:outline-none min-w-0">
                    <div class="relative w-10 h-10 sm:w-12 sm:h-12 shrink-0 rounded-2xl overflow-hidden border border-emerald-100 bg-white p-0.5 shadow-sm group-hover:scale-105 transition duration-200">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Rohis Darul Muttaqin" class="w-full h-full object-cover rounded-xl">
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-sm sm:text-lg lg:text-xl font-extrabold tracking-tight text-slate-900 leading-tight group-hover:text-emerald-700 transition truncate">
                            Rohis Darul Muttaqin
                        </span>
                        <span class="hidden xs:block text-[10px] sm:text-[11px] font-semibold text-emerald-700 tracking-wide truncate">
                            Wadah Ukhuwah & Dakwah Siswa
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-1 text-sm font-semibold text-slate-600">
                    <a href="{{ route('home') }}" 
                       class="px-3.5 py-2 rounded-xl transition duration-150 {{ request()->routeIs('home') && !request()->has('section') ? 'text-emerald-800 bg-emerald-50/90 font-bold' : 'hover:text-emerald-700 hover:bg-slate-100/80' }}">
                        Beranda
                    </a>
                    <a href="{{ route('home') }}#tentang" 
                       class="px-3.5 py-2 rounded-xl transition duration-150 hover:text-emerald-700 hover:bg-slate-100/80">
                        Tentang
                    </a>
                    <a href="{{ route('schedule.index') }}" 
                       class="px-3.5 py-2 rounded-xl transition duration-150 {{ request()->routeIs('schedule.*') ? 'text-emerald-800 bg-emerald-50/90 font-bold' : 'hover:text-emerald-700 hover:bg-slate-100/80' }}">
                        Kegiatan
                    </a>
                    <a href="{{ route('officer.index') }}" 
                       class="px-3.5 py-2 rounded-xl transition duration-150 {{ request()->routeIs('officer.*') ? 'text-emerald-800 bg-emerald-50/90 font-bold' : 'hover:text-emerald-700 hover:bg-slate-100/80' }}">
                        Pengurus
                    </a>
                    <a href="{{ route('announcement.index') }}"
                       class="px-3.5 py-2 rounded-xl transition duration-150 {{ request()->routeIs('announcement.*') ? 'text-emerald-800 bg-emerald-50/90 font-bold' : 'hover:text-emerald-700 hover:bg-slate-100/80' }}">
                        Pengumuman
                    </a>
                    <a href="{{ route('home') }}#galeri" 
                       class="px-3.5 py-2 rounded-xl transition duration-150 hover:text-emerald-700 hover:bg-slate-100/80">
                        Galeri
                    </a>
                    <a href="{{ route('home') }}#faq" 
                       class="px-3.5 py-2 rounded-xl transition duration-150 hover:text-emerald-700 hover:bg-slate-100/80">
                        Tanya Jawab
                    </a>
                </nav>

                <!-- Desktop Action Buttons -->
                <div class="hidden sm:flex items-center gap-3 shrink-0">
                    <a href="{{ route('register.create') }}" class="cta-primary">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <span>Daftar Anggota</span>
                    </a>
                </div>

                <!-- Mobile Action Buttons & Hamburger -->
                <div class="flex items-center gap-2 lg:hidden shrink-0">
                    <a href="{{ route('register.create') }}" class="sm:hidden inline-flex items-center gap-1 rounded-xl bg-emerald-700 px-2.5 py-1.5 text-xs font-bold text-white shadow-xs hover:bg-emerald-800 transition active:scale-95">
                        <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                        <span>Daftar</span>
                    </a>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            type="button" 
                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-slate-50 p-2 text-slate-700 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 active:scale-95 transition"
                            aria-label="Toggle Menu">
                        <span x-show="!mobileMenuOpen">
                            <x-icon name="menu" class="w-5 h-5" />
                        </span>
                        <span x-show="mobileMenuOpen" x-cloak>
                            <x-icon name="x" class="w-5 h-5" />
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Backdrop Overlay -->
        <div x-show="mobileMenuOpen" 
             x-cloak
             @click="mobileMenuOpen = false"
             x-transition:enter="transition-opacity ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 top-16 sm:top-20 z-40 bg-slate-950/40 backdrop-blur-xs lg:hidden"></div>

        <!-- Mobile Navigation Drawer -->
        <div x-show="mobileMenuOpen" 
             x-cloak 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="relative z-50 border-b border-slate-200 bg-white/98 backdrop-blur-2xl lg:hidden shadow-xl max-h-[calc(100vh-4rem)] sm:max-h-[calc(100vh-5rem)] overflow-y-auto">
            <div class="px-4 pt-3 pb-6 space-y-1.5">
                <a @click="mobileMenuOpen = false" href="{{ route('home') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-700 hover:bg-slate-50' }}">
                    <x-icon name="home" class="w-4 h-4 text-emerald-600" />
                    Beranda
                </a>
                <a @click="mobileMenuOpen = false" href="{{ route('home') }}#tentang" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    <x-icon name="book-open" class="w-4 h-4 text-emerald-600" />
                    Tentang Kami
                </a>
                <a @click="mobileMenuOpen = false" href="{{ route('schedule.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('schedule.*') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-700 hover:bg-slate-50' }}">
                    <x-icon name="calendar" class="w-4 h-4 text-emerald-600" />
                    Agenda & Kegiatan
                </a>
                <a @click="mobileMenuOpen = false" href="{{ route('officer.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('officer.*') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-700 hover:bg-slate-50' }}">
                    <x-icon name="users" class="w-4 h-4 text-emerald-600" />
                    Struktur Pengurus
                </a>
                <a @click="mobileMenuOpen = false" href="{{ route('home') }}#galeri" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    <x-icon name="image" class="w-4 h-4 text-emerald-600" />
                    Dokumentasi Galeri
                </a>
                <a @click="mobileMenuOpen = false" href="{{ route('home') }}#faq" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    <x-icon name="help-circle" class="w-4 h-4 text-emerald-600" />
                    Tanya Jawab (FAQ)
                </a>

                <div class="pt-4 border-t border-slate-100 flex flex-col gap-2.5">
                    <a href="{{ route('register.create') }}" class="cta-primary w-full text-center">
                        <x-icon name="user-plus" class="w-4 h-4" />
                        Formulir Pendaftaran Anggota
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT SLOT -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- UNIFIED FOOTER -->
    <footer class="bg-slate-900 text-slate-300 border-t border-slate-800 mt-16">
        <!-- Hadits / Motto Banner -->
        <div class="border-b border-slate-800/80 bg-slate-950/60 py-6 px-4">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4 text-center md:text-left">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-950 border border-emerald-800/80 flex items-center justify-center text-emerald-400">
                        <x-icon name="mosque" class="w-5 h-5" />
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white tracking-wide">"خَيْرُ النَّاسِ أَنْفَعُهُمْ لِلنَّاسِ"</p>
                        <p class="text-xs text-slate-400">Sebaik-baik manusia adalah yang paling bermanfaat bagi orang lain. (HR. Thabrani)</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-emerald-400 bg-emerald-950/80 border border-emerald-800 px-3 py-1 rounded-full">
                        Semangat Berdakwah & Berukhuwah
                    </span>
                </div>
            </div>
        </div>

        <!-- Main Footer Columns -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <!-- Col 1: Identity -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Rohis" class="w-11 h-11 rounded-xl bg-white p-0.5 object-cover">
                        <div>
                            <h3 class="font-extrabold text-white text-base">Rohis Darul Muttaqin</h3>
                            <p class="text-xs text-emerald-400 font-semibold">Organisasi Kerohanian Islam</p>
                        </div>
                    </div>
                    <p class="text-xs leading-relaxed text-slate-400">
                        Wadah pembinaan karakter, penempaan iman, dan penguatan ukhuwah Islamiyah bagi seluruh siswa. Belajar dan tumbuh bersama dalam suasana yang hangat, santun, dan inspiratif.
                    </p>
                    <div class="pt-2">
                        <span class="inline-flex items-center gap-1.5 text-xs text-emerald-400 bg-emerald-950/60 border border-emerald-900 px-3 py-1.5 rounded-lg">
                            <x-icon name="sparkles" class="w-3.5 h-3.5" />
                            Terbuka untuk Seluruh Siswa Muslim
                        </span>
                    </div>
                </div>

                <!-- Col 2: Navigasi Cepat -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider text-white mb-4">Navigasi Utama</h4>
                    <ul class="space-y-2.5 text-xs">
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-emerald-400 transition flex items-center gap-2">
                                <x-icon name="chevron-right" class="w-3.5 h-3.5 text-emerald-500" />
                                Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}#tentang" class="hover:text-emerald-400 transition flex items-center gap-2">
                                <x-icon name="chevron-right" class="w-3.5 h-3.5 text-emerald-500" />
                                Profil & Nilai Utama
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('schedule.index') }}" class="hover:text-emerald-400 transition flex items-center gap-2">
                                <x-icon name="chevron-right" class="w-3.5 h-3.5 text-emerald-500" />
                                Agenda & Kegiatan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('officer.index') }}" class="hover:text-emerald-400 transition flex items-center gap-2">
                                <x-icon name="chevron-right" class="w-3.5 h-3.5 text-emerald-500" />
                                Susunan Pengurus
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}#galeri" class="hover:text-emerald-400 transition flex items-center gap-2">
                                <x-icon name="chevron-right" class="w-3.5 h-3.5 text-emerald-500" />
                                Dokumentasi Kegiatan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register.create') }}" class="hover:text-emerald-400 transition flex items-center gap-2 font-bold text-emerald-400">
                                <x-icon name="chevron-right" class="w-3.5 h-3.5 text-emerald-400" />
                                Formulir Pendaftaran Anggota
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Program & Kegiatan -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider text-white mb-4">Program Unggulan</h4>
                    <ul class="space-y-2.5 text-xs">
                        <li class="flex items-start gap-2">
                            <x-icon name="book-open" class="w-3.5 h-3.5 text-emerald-400 mt-0.5 shrink-0" />
                            <span>Kajian Akbar & Diskusi Keislaman Rutin</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icon name="mosque" class="w-3.5 h-3.5 text-emerald-400 mt-0.5 shrink-0" />
                            <span>Piket & Pemakmuran Masjid Sekolah</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icon name="heart" class="w-3.5 h-3.5 text-emerald-400 mt-0.5 shrink-0" />
                            <span>Bakti Sosial, Infaq, & Santunan Siswa</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icon name="sparkles" class="w-3.5 h-3.5 text-emerald-400 mt-0.5 shrink-0" />
                            <span>Mabit (Malam Bina Iman dan Taqwa)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icon name="users" class="w-3.5 h-3.5 text-emerald-400 mt-0.5 shrink-0" />
                            <span>Latihan Kepemimpinan & Rihlah Ukhuwah</span>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Kontak & Media Sosial -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider text-white mb-4">Media Sosial & Hubungan</h4>
                    <p class="text-xs text-slate-400 mb-4 leading-relaxed">
                        Ikuti perkembangan kabar, siaran dakwah, dan agenda kami di kanal resmi berikut:
                    </p>
                    <div class="space-y-2.5 text-xs">
                        @if(isset($socialInstagram) && filled($socialInstagram))
                            <a href="{{ $socialInstagram }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2.5 text-slate-300 hover:text-white transition">
                                <div class="w-7 h-7 rounded-lg bg-slate-800 flex items-center justify-center text-pink-400 border border-slate-700">
                                    <x-icon name="instagram" class="w-4 h-4" />
                                </div>
                                <span>Instagram Resmi</span>
                            </a>
                        @endif

                        @if(isset($socialWhatsapp) && filled($socialWhatsapp))
                            <a href="{{ $socialWhatsapp }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2.5 text-slate-300 hover:text-white transition">
                                <div class="w-7 h-7 rounded-lg bg-slate-800 flex items-center justify-center text-emerald-400 border border-slate-700">
                                    <x-icon name="whatsapp" class="w-4 h-4" />
                                </div>
                                <span>WhatsApp Pengurus</span>
                            </a>
                        @endif

                        @if(isset($socialYoutube) && filled($socialYoutube))
                            <a href="{{ $socialYoutube }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2.5 text-slate-300 hover:text-white transition">
                                <div class="w-7 h-7 rounded-lg bg-slate-800 flex items-center justify-center text-red-400 border border-slate-700">
                                    <x-icon name="youtube" class="w-4 h-4" />
                                </div>
                                <span>YouTube Channel</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Copyright Bar -->
        <div class="border-t border-slate-800/80 py-6 px-4 bg-slate-950">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Rohis Darul Muttaqin. Seluruh Hak Cipta Dilindungi.</p>
                <div class="flex items-center gap-4">
                    <span>Membangun Generasi Robbani</span>
                    <span>•</span>
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-400 transition">Portal Pengurus</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
    <script>lucide.createIcons();</script>
</body>
</html>
