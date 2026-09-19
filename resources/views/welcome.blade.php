<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rohis Darul Muttaqin - Organisasi Kerohanian Islam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Animasi halus untuk FAQ */
        details > summary { list-style: none; }
        details > summary::-webkit-details-marker { display: none; }
    </style>
</head>
<body class="min-h-screen overflow-x-hidden antialiased bg-gradient-to-br from-emerald-50/70 via-slate-50 to-teal-50/40 text-slate-800">

    <!-- Sticky Navbar -->
    <header class="sticky top-0 z-50 border-b shadow-sm border-emerald-100/80 bg-white/90 backdrop-blur-xl">
        <div class="flex items-center justify-between h-20 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Rohis" class="object-cover w-12 h-12 transition duration-300 rounded-full shadow-md shadow-emerald-600/25 group-hover:scale-105">
                <div class="hidden flex-col sm:flex">
                    <span class="text-xl font-black leading-none tracking-tight text-slate-900">Rohis Darul Muttaqin</span>
                    <span class="mt-1 text-[10px] font-bold uppercase tracking-[0.22em] text-emerald-700">Organisasi Kerohanian Islam</span>
                </div>
            </a>

            <!-- Menu Explorasi -->
            <nav class="hidden items-center space-x-6 text-sm font-bold text-slate-600 lg:flex">
                <a href="#beranda" class="transition duration-200 hover:text-emerald-700">Beranda</a>
                <a href="#tentang" class="transition duration-200 hover:text-emerald-700">Tentang</a>
                <a href="#kegiatan" class="transition duration-200 hover:text-emerald-700">Kegiatan</a>
                <a href="#pengurus" class="transition duration-200 hover:text-emerald-700">Pengurus</a>
                <a href="#galeri" class="transition duration-200 hover:text-emerald-700">Galeri</a>
                <a href="#faq" class="transition duration-200 hover:text-emerald-700">FAQ</a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="{{ route('register.create') }}" class="hidden md:inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 px-4 py-2 text-sm font-bold text-white shadow-md shadow-emerald-600/20 transition duration-200 hover:bg-emerald-700">
                    Daftar
                </a>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-gray-800 to-gray-900 px-5 py-2.5 text-xs font-black tracking-wide text-white shadow-lg transition duration-300 hover:-translate-y-0.5 hover:shadow-gray-900/30">
                    Dashboard Admin
                </a>
            </div>
        </div>
    </header>

    <main>
        <!-- HERO SECTION -->
        @php
            $heroImageUrl = $heroImage ?? null;
            $defaultHeroImage = 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80';
            $isValidHeroImage = false;
            if (filled($heroImageUrl) && filter_var($heroImageUrl, FILTER_VALIDATE_URL)) {
                $heroImageUrl = $heroImageUrl;
                $isValidHeroImage = true;
            } elseif (filled($heroImageUrl) && Storage::disk('public')->exists($heroImageUrl)) {
                $heroImageUrl = asset('storage/' . $heroImageUrl);
                $isValidHeroImage = true;
            }
            if (! $isValidHeroImage) { $heroImageUrl = $defaultHeroImage; }
        @endphp

        <section id="beranda" class="relative w-full min-h-[85vh] md:min-h-[650px] flex items-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img src="{{ $heroImageUrl }}" alt="Hero Background" class="object-cover object-center w-full h-full">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/95 via-slate-900/80 to-transparent"></div>
            </div>

            <div class="relative z-10 w-full px-4 py-20 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="max-w-3xl space-y-6 animate-fade-up">
                    <span class="inline-flex items-center gap-2 px-4 py-2 text-xs font-extrabold tracking-[0.1em] text-white uppercase border rounded-full shadow-sm border-white/20 bg-white/10 backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                        {{ \App\Models\Setting::get('hero_badge', 'Komunitas Rohis Modern') }}
                    </span>

                    <h1 class="text-4xl font-black leading-tight tracking-tight text-white sm:text-5xl lg:text-[56px] drop-shadow-lg">
                        {{ \App\Models\Setting::get('hero_title_main', 'Membentuk Generasi Muda Islam yang') }} 
                        <span class="text-yellow-400">{{ \App\Models\Setting::get('hero_title_highlight', 'Berakhlak, Cerdas, dan Inklusif') }}</span>
                    </h1>

                    <p class="max-w-2xl text-lg font-medium leading-relaxed text-slate-200 md:text-xl">
                        {{ \App\Models\Setting::get('hero_description', 'Rohis Darul Muttaqin hadir sebagai wadah kebaikan dan ruang bertumbuh bagi siswa-siswi untuk memperdalam pemahaman agama, mempererat ukhuwah Islamiyah, dan mengembangkan potensi diri dalam suasana yang aman, inspiratif, serta menyenangkan.') }}
                    </p>

                    <div class="flex flex-col gap-4 pt-4 sm:flex-row">
                        <a href="{{ route('register.create') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-extrabold transition duration-300 rounded-full shadow-xl text-slate-900 bg-yellow-400 hover:bg-yellow-500 shadow-yellow-500/25 hover:-translate-y-1">
                            Daftar Anggota Baru <span class="ml-2" aria-hidden="true">→</span>
                        </a>
                        <a href="#tentang" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white transition duration-300 bg-transparent border rounded-full shadow-sm border-white/50 hover:-translate-y-1 hover:border-white hover:bg-white/10 backdrop-blur-sm">
                            Jelajahi Lebih Lanjut
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- STATISTICS GRID -->
        <section class="relative px-4 pt-12 pb-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div class="flex items-center gap-4 rounded-[2rem] border border-emerald-100/90 bg-white/90 p-5 shadow-[0_12px_30px_rgba(15,118,110,0.05)] backdrop-blur-xl transition hover:-translate-y-1">
                    <div class="flex items-center justify-center text-white shadow-md h-14 w-14 shrink-0 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600">
                        <i data-lucide="users" class="h-7 w-7"></i>
                    </div>
                    <div>
                        <p class="text-3xl font-black tracking-tight text-slate-900">{{ $activeMembers ?? 120 }}+</p>
                        <p class="text-xs font-bold uppercase tracking-[0.15em] text-emerald-700">Anggota Aktif</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 rounded-[2rem] border border-emerald-100/90 bg-white/90 p-5 shadow-[0_12px_30px_rgba(15,118,110,0.05)] backdrop-blur-xl transition hover:-translate-y-1">
                    <div class="flex items-center justify-center text-white shadow-md h-14 w-14 shrink-0 rounded-2xl bg-gradient-to-br from-teal-500 to-emerald-600">
                        <i data-lucide="calendar-days" class="h-7 w-7"></i>
                    </div>
                    <div>
                        <p class="text-3xl font-black tracking-tight text-slate-900">{{ $totalPrograms ?? 12 }}+</p>
                        <p class="text-xs font-bold uppercase tracking-[0.15em] text-teal-700">Program</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 rounded-[2rem] border border-emerald-100/90 bg-white/90 p-5 shadow-[0_12px_30px_rgba(15,118,110,0.05)] backdrop-blur-xl transition hover:-translate-y-1">
                    <div class="flex items-center justify-center text-white shadow-md h-14 w-14 shrink-0 rounded-2xl bg-gradient-to-br from-emerald-600 to-green-700">
                        <i data-lucide="book-open" class="h-7 w-7"></i>
                    </div>
                    <div>
                        <p class="text-3xl font-black tracking-tight text-slate-900">Rutin</p>
                        <p class="text-xs font-bold uppercase tracking-[0.15em] text-emerald-800">Kajian</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 rounded-[2rem] border border-emerald-100/90 bg-white/90 p-5 shadow-[0_12px_30px_rgba(15,118,110,0.05)] backdrop-blur-xl transition hover:-translate-y-1">
                    <div class="flex items-center justify-center text-white shadow-md h-14 w-14 shrink-0 rounded-2xl bg-gradient-to-br from-teal-600 to-emerald-700">
                        <i data-lucide="heart-handshake" class="h-7 w-7"></i>
                    </div>
                    <div>
                        <p class="text-3xl font-black tracking-tight text-slate-900">100%</p>
                        <p class="text-xs font-bold uppercase tracking-[0.15em] text-teal-800">Ukhuwah</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- TENTANG KAMI SECTION -->
        <section id="tentang" class="relative px-4 pt-8 pb-16 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-[2.5rem] border border-emerald-100 bg-gradient-to-br from-white via-emerald-50/50 to-teal-50/30 p-8 md:p-12">
                <div class="relative flex flex-col gap-3 mb-10 text-center">
                    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-emerald-700">Tentang Kami</p>
                    <h2 class="mt-2 text-3xl font-black tracking-tight text-slate-900 md:text-4xl">Lingkungan belajar yang menenangkan</h2>
                </div>

                <div class="grid gap-8 md:grid-cols-3">
                    <article class="text-center p-6">
                        <div class="mx-auto flex items-center justify-center w-16 h-16 mb-5 text-emerald-700 bg-emerald-100 rounded-full">
                            <i data-lucide="book-open-text" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">Akhlak & Ibadah</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">Membentuk karakter yang kuat dengan pemahaman agama yang aplikatif.</p>
                    </article>
                    <article class="text-center p-6 border-y md:border-y-0 md:border-x border-gray-200/50">
                        <div class="mx-auto flex items-center justify-center w-16 h-16 mb-5 text-teal-700 bg-teal-100 rounded-full">
                            <i data-lucide="sparkles" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">Inspiratif & Santai</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">Kegiatan yang didesain menyenangkan sekaligus memberi manfaat besar.</p>
                    </article>
                    <article class="text-center p-6">
                        <div class="mx-auto flex items-center justify-center w-16 h-16 mb-5 text-emerald-700 bg-emerald-100 rounded-full">
                            <i data-lucide="handshake" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">Ukhuwah Kuat</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">Bersama-sama tumbuh dalam semangat solidaritas dan empati.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- KEGIATAN SECTION -->
        <section id="kegiatan" class="py-16 bg-slate-50">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex flex-col gap-3 mb-10 text-center">
                    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-emerald-700">Agenda Rutin</p>
                    <h2 class="text-3xl font-black tracking-tight text-slate-900 md:text-4xl">Program Unggulan Kami</h2>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    @if(isset($schedules) && $schedules->isNotEmpty())
                        @foreach($schedules->take(3) as $index => $schedule)
                            <article class="overflow-hidden bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-lg transition duration-300">
                                @if($schedule->image_path && Storage::disk('public')->exists($schedule->image_path))
                                    <img src="{{ asset('storage/' . $schedule->image_path) }}" alt="{{ $schedule->title }}" class="object-cover w-full h-48">
                                @else
                                    <div class="flex h-48 w-full items-center justify-center bg-emerald-50 text-emerald-300">
                                        <i data-lucide="image" class="w-12 h-12"></i>
                                    </div>
                                @endif
                                <div class="p-6">
                                    <span class="text-xs font-bold text-emerald-600 uppercase">{{ $schedule->event_date ? $schedule->event_date->format('d M Y') : '-' }}</span>
                                    <h3 class="mt-2 text-xl font-black text-slate-900">{{ $schedule->title }}</h3>
                                    <p class="mt-3 text-sm text-slate-600 line-clamp-3">{{ $schedule->description }}</p>
                                </div>
                            </article>
                        @endforeach
                    @else
                        <!-- DUMMY DATA KEGIATAN JIKA KOSONG -->
                        @foreach(['Kajian Akbar Mingguan', 'Mabit (Malam Bina Iman)', 'Rihlah & Outbound'] as $kegiatan)
                            <article class="overflow-hidden bg-white border border-gray-100 rounded-2xl shadow-sm">
                                <div class="flex h-48 w-full items-center justify-center bg-slate-100 text-slate-400">Belum ada foto kegiatan</div>
                                <div class="p-6">
                                    <h3 class="mt-2 text-xl font-black text-slate-900">{{ $kegiatan }}</h3>
                                    <p class="mt-3 text-sm text-slate-600">Penjelasan detail kegiatan akan muncul di sini saat admin menambahkannya.</p>
                                </div>
                            </article>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>

        <!-- PENGURUS SECTION -->
        <section id="pengurus" class="py-20 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-emerald-700">Pimpinan & Kadiv</p>
                <h2 class="mt-2 text-3xl font-black tracking-tight text-slate-900 md:text-4xl">Kenalan dengan Pengurus Rohis</h2>
            </div>
            
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
                @if(isset($officers) && $officers->isNotEmpty())
                    @foreach($officers->take(4) as $officer)
                        <div class="text-center group">
                            <div class="relative w-32 h-32 mx-auto mb-4 overflow-hidden rounded-full ring-4 ring-emerald-50">
                                @if($officer->image_path && Storage::disk('public')->exists($officer->image_path))
                                    <img src="{{ asset('storage/' . $officer->image_path) }}" alt="{{ $officer->name }}" class="object-cover w-full h-full transition duration-300 group-hover:scale-110">
                                @else
                                    <div class="flex items-center justify-center w-full h-full bg-emerald-100 text-emerald-600 font-bold text-3xl uppercase">
                                        {{ substr($officer->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">{{ $officer->name }}</h3>
                            <p class="text-sm font-medium text-emerald-600">{{ $officer->position }}</p>
                        </div>
                    @endforeach
                @else
                    <!-- DUMMY DATA PENGURUS JIKA KOSONG -->
                    @foreach(['Ketua Umum', 'Wakil Ketua', 'Sekretaris', 'Bendahara'] as $jabatan)
                        <div class="text-center">
                            <div class="relative w-32 h-32 mx-auto mb-4 rounded-full ring-4 ring-slate-50 bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-3xl">
                                ?
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">Nama Pengurus</h3>
                            <p class="text-sm font-medium text-emerald-600">{{ $jabatan }}</p>
                        </div>
                    @endforeach
                @endif
            </div>
            
            <div class="mt-12 text-center">
                <a href="{{ route('officer.index') }}" class="inline-flex items-center text-sm font-bold text-emerald-600 hover:text-emerald-800 transition">
                    Lihat Seluruh Struktur Pengurus →
                </a>
            </div>
        </section>

        <!-- WIDGET PIKET MASJID HARI INI -->
        @if(in_array($hariIni ?? '', ['Senin', 'Kamis']) && isset($piketHariIni) && $piketHariIni->count() > 0)
        <div class="px-4 mx-auto mb-16 max-w-7xl sm:px-6 lg:px-8">
            <div class="relative p-6 overflow-hidden border border-emerald-200 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl md:p-8">
                <div class="relative z-10 flex flex-col md:flex-row gap-8 items-center justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-3xl">🕌</span>
                            <h3 class="text-2xl font-black tracking-tight text-emerald-900">Piket Masjid Hari Ini ({{ $hariIni }})</h3>
                        </div>
                        <p class="text-sm text-emerald-700 font-medium">Jazakumullah khairan untuk teman-teman yang bertugas menjaga kebersihan rumah Allah hari ini.</p>
                    </div>
                    
                    <div class="flex gap-4 w-full md:w-auto">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-emerald-100 flex-1">
                            <h4 class="font-bold text-emerald-800 border-b pb-2 mb-2">👦🏻 Ikhwan</h4>
                            <ul class="text-sm text-slate-700 space-y-1">
                                @foreach($piketHariIni->where('gender', 'Ikhwan') as $piket)
                                    <li>• {{ $piket->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-emerald-100 flex-1">
                            <h4 class="font-bold text-emerald-800 border-b pb-2 mb-2">🧕🏻 Akhwat</h4>
                            <ul class="text-sm text-slate-700 space-y-1">
                                @foreach($piketHariIni->where('gender', 'Akhwat') as $piket)
                                    <li>• {{ $piket->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- GALLERY SECTION (SELALU MUNCUL) -->
        <section id="galeri" class="py-16 bg-slate-900 text-white">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-emerald-400">Galeri</p>
                    <h2 class="mt-2 text-3xl font-black tracking-tight md:text-4xl">Momen Kebersamaan Kita</h2>
                </div>
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                    @if(isset($galleries) && $galleries->isNotEmpty())
                        @foreach($galleries->take(6) as $gallery)
                            <div class="group relative aspect-square overflow-hidden rounded-xl bg-slate-800">
                                <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="object-cover w-full h-full transition duration-500 group-hover:scale-110 opacity-80 group-hover:opacity-100">
                            </div>
                        @endforeach
                    @else
                        <!-- DUMMY DATA GALERI JIKA KOSONG -->
                        @for($i=1; $i<=3; $i++)
                            <div class="group relative aspect-square overflow-hidden rounded-xl bg-slate-800 flex items-center justify-center border border-slate-700/50">
                                <span class="text-slate-500 text-sm font-bold">Foto Galeri Belum Diunggah</span>
                            </div>
                        @endfor
                    @endif
                </div>
            </div>
        </section>

        <!-- FAQ SECTION (SELALU MUNCUL) -->
        <section id="faq" class="py-20 px-4 mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-emerald-700">Tanya Jawab</p>
                <h2 class="mt-2 text-3xl font-black tracking-tight text-slate-900 md:text-4xl">Pertanyaan Sering Muncul</h2>
            </div>
            
            <div class="space-y-4">
                @if(isset($faqs) && $faqs->isNotEmpty())
                    @foreach($faqs as $faq)
                    <details class="group border border-gray-200 bg-white rounded-xl shadow-sm [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-5 text-gray-900">
                            <h3 class="font-bold">{{ $faq->question }}</h3>
                            <span class="relative size-5 shrink-0">
                                <i data-lucide="plus-circle" class="absolute inset-0 size-5 opacity-100 group-open:opacity-0 transition"></i>
                                <i data-lucide="minus-circle" class="absolute inset-0 size-5 opacity-0 group-open:opacity-100 transition"></i>
                            </span>
                        </summary>
                        <div class="px-5 pb-5 pt-0">
                            <p class="text-sm leading-relaxed text-gray-600">{{ $faq->answer }}</p>
                        </div>
                    </details>
                    @endforeach
                @else
                    <!-- DUMMY DATA FAQ JIKA KOSONG -->
                    <details class="group border border-gray-200 bg-white rounded-xl shadow-sm [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-5 text-gray-900">
                            <h3 class="font-bold">Apakah Rohis hanya untuk yang sudah pintar agama?</h3>
                            <span class="relative size-5 shrink-0 text-emerald-600">
                                <i data-lucide="plus-circle" class="absolute inset-0 size-5 opacity-100 group-open:opacity-0 transition"></i>
                                <i data-lucide="minus-circle" class="absolute inset-0 size-5 opacity-0 group-open:opacity-100 transition"></i>
                            </span>
                        </summary>
                        <div class="px-5 pb-5 pt-0">
                            <p class="text-sm leading-relaxed text-gray-600">Tentu saja tidak. Rohis adalah tempat kita belajar bersama dari nol. Tidak ada syarat harus pandai membaca Al-Quran atau paham agama secara mendalam. Yang penting ada kemauan untuk belajar dan memperbaiki diri bersama.</p>
                        </div>
                    </details>
                    <details class="group border border-gray-200 bg-white rounded-xl shadow-sm [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-5 text-gray-900">
                            <h3 class="font-bold">Kapan pendaftaran anggota baru dibuka?</h3>
                            <span class="relative size-5 shrink-0 text-emerald-600">
                                <i data-lucide="plus-circle" class="absolute inset-0 size-5 opacity-100 group-open:opacity-0 transition"></i>
                                <i data-lucide="minus-circle" class="absolute inset-0 size-5 opacity-0 group-open:opacity-100 transition"></i>
                            </span>
                        </summary>
                        <div class="px-5 pb-5 pt-0">
                            <p class="text-sm leading-relaxed text-gray-600">Pendaftaran anggota baru dibuka setiap saat melalui website ini (klik tombol Daftar di atas). Namun penerimaan resmi dan kegiatan orientasi biasanya diadakan di awal tahun ajaran baru.</p>
                        </div>
                    </details>
                @endif
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="py-12 border-t border-gray-200 bg-white">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex flex-col gap-8 text-center md:flex-row md:items-center md:justify-between md:text-left">
                <div>
                    <div class="flex items-center justify-center gap-3 md:justify-start mb-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Rohis" class="object-cover w-8 h-8 rounded-full">
                        <p class="font-black text-slate-900">Rohis Darul Muttaqin</p>
                    </div>
                    <p class="text-xs font-medium text-slate-500">&copy; {{ date('Y') }} Membangun generasi rabbani.</p>
                </div>
            </div>
        </div>
    </footer>

    <script>lucide.createIcons();</script>
</body>
</html>