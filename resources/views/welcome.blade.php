<x-public-layout :title="'Rohis Darul Muttaqin - Organisasi Kerohanian Islam'" :active="'home'">

    <!-- HERO SECTION -->
    @php
        $heroImageUrl = $heroImage ?? null;
        $defaultHeroImage = 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80';
        $isValidHeroImage = false;
        if (filled($heroImageUrl) && filter_var($heroImageUrl, FILTER_VALIDATE_URL)) {
            $isValidHeroImage = true;
        } elseif (filled($heroImageUrl) && Storage::disk('public')->exists($heroImageUrl)) {
            $heroImageUrl = asset('storage/' . $heroImageUrl);
            $isValidHeroImage = true;
        }
        if (! $isValidHeroImage) { 
            $heroImageUrl = $defaultHeroImage; 
        }
    @endphp

    <section id="beranda" class="relative w-full min-h-[600px] lg:min-h-[660px] flex items-center overflow-hidden bg-slate-950 text-white">
        <!-- Background Image with sophisticated Islamic dark overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ $heroImageUrl }}" alt="Hero Background" class="object-cover object-center w-full h-full opacity-35 filter saturate-50">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/90 to-emerald-950/70"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-emerald-600/15 via-transparent to-transparent"></div>
        </div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12 items-center">
                <!-- Left Text Content -->
                <div class="lg:col-span-8 space-y-6 animate-fade-up">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-emerald-500/30 bg-emerald-950/70 backdrop-blur-md text-emerald-300 text-xs font-bold uppercase tracking-widest">
                        <x-icon name="crescent" class="w-3.5 h-3.5 text-amber-400" />
                        <span>{{ \App\Models\Setting::get('hero_badge', 'Komunitas Kerohanian Islam Siswa') }}</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black leading-[1.15] tracking-tight text-white">
                        {{ \App\Models\Setting::get('hero_title_main', 'Membentuk Generasi Muda Islam yang') }}
                        <span class="block mt-1 text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-amber-300">
                            {{ \App\Models\Setting::get('hero_title_highlight', 'Berakhlak, Cerdas, dan Inklusif') }}
                        </span>
                    </h1>

                    <p class="max-w-2xl text-base sm:text-lg font-normal leading-relaxed text-slate-300">
                        {{ \App\Models\Setting::get('hero_description', 'Rohis Darul Muttaqin hadir sebagai ruang bertumbuh bagi siswa-siswi untuk memperdalam pemahaman agama, mempererat ukhuwah Islamiyah, dan mengembangkan potensi diri dalam suasana yang santun, hangat, serta menginspirasi.') }}
                    </p>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5 pt-3">
                        <a href="{{ route('register.create') }}" class="cta-primary bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold px-7 py-3.5 text-base shadow-lg shadow-emerald-950/40">
                            <x-icon name="user-plus" class="w-5 h-5" />
                            <span>Daftar Anggota Baru</span>
                            <x-icon name="arrow-right" class="w-4 h-4 ml-1" />
                        </a>
                        <a href="#tentang" class="cta-secondary bg-white/10 hover:bg-white/20 text-white border-white/20 px-6 py-3.5 text-base backdrop-blur-md">
                            <x-icon name="book-open" class="w-5 h-5 text-emerald-400" />
                            <span>Kenali Program Kami</span>
                        </a>
                    </div>
                </div>

                <!-- Right Quick Info Card -->
                <div class="lg:col-span-4 hidden lg:block">
                    <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl p-6 shadow-2xl space-y-5">
                        <div class="flex items-center gap-3 pb-4 border-b border-white/10">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400">
                                <x-icon name="mosque" class="w-5 h-5" />
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-white">Darul Muttaqin</h2>
                                <p class="text-xs text-slate-400">Pusat Pembinaan Karakter Siswa</p>
                            </div>
                        </div>

                        <div class="space-y-3 text-xs">
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/5">
                                <div class="w-7 h-7 rounded-lg bg-emerald-900/60 flex items-center justify-center text-emerald-300">
                                    <x-icon name="users" class="w-3.5 h-3.5" />
                                </div>
                                <div>
                                    <p class="text-white font-bold">{{ $activeMembers ?? 120 }}+ Anggota Terdaftar</p>
                                    <p class="text-slate-400">Aktif dalam kegiatan mingguan</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/5">
                                <div class="w-7 h-7 rounded-lg bg-amber-900/60 flex items-center justify-center text-amber-300">
                                    <x-icon name="calendar" class="w-3.5 h-3.5" />
                                </div>
                                <div>
                                    <p class="text-white font-bold">{{ $totalPrograms ?? 12 }}+ Agenda Kegiatan</p>
                                    <p class="text-slate-400">Kajian, baksos, & mentoring</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2">
                            <div class="text-[11px] text-emerald-300/90 italic bg-emerald-950/40 p-3 rounded-xl border border-emerald-900/50">
                                "Menjadikan masjid sekolah sebagai rumah kedua yang meneduhkan dan memancarkan kebaikan."
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TENTANG KAMI / NILAI UTAMA -->
    <section id="tentang" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-3">
            <span class="rohis-badge">
                <x-icon name="sparkles" class="w-3.5 h-3.5 text-emerald-600" />
                Nilai & Landasan Kami
            </span>
            <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900">
                Pilar Utama Pembinaan Rohis
            </h2>
            <p class="text-sm sm:text-base text-slate-600">
                Kami berkomitmen menciptakan ekosistem kebaikan yang ramah, santun, dan aplikatif bagi seluruh pelajar muslim.
            </p>
        </div>

        {{-- STATISTIK --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-14">
            <div class="relative overflow-hidden text-center py-7 px-4 rounded-2xl border border-emerald-100 bg-gradient-to-br from-emerald-50 to-white shadow-xs hover:shadow-md hover:-translate-y-0.5 transition duration-200">
                <p class="text-3xl sm:text-4xl font-black tracking-tight text-emerald-700">{{ $statAnggota }}</p>
                <p class="mt-1.5 text-[11px] sm:text-xs font-bold uppercase tracking-widest text-slate-500">{{ $statAnggotaLabel }}</p>
                <div class="absolute -bottom-3 -right-3 w-14 h-14 rounded-full bg-emerald-100/60"></div>
            </div>
            <div class="relative overflow-hidden text-center py-7 px-4 rounded-2xl border border-teal-100 bg-gradient-to-br from-teal-50 to-white shadow-xs hover:shadow-md hover:-translate-y-0.5 transition duration-200">
                <p class="text-3xl sm:text-4xl font-black tracking-tight text-teal-700">{{ $statProgram }}</p>
                <p class="mt-1.5 text-[11px] sm:text-xs font-bold uppercase tracking-widest text-slate-500">{{ $statProgramLabel }}</p>
                <div class="absolute -bottom-3 -right-3 w-14 h-14 rounded-full bg-teal-100/60"></div>
            </div>
            <div class="relative overflow-hidden text-center py-7 px-4 rounded-2xl border border-amber-100 bg-gradient-to-br from-amber-50 to-white shadow-xs hover:shadow-md hover:-translate-y-0.5 transition duration-200">
                <p class="text-3xl sm:text-4xl font-black tracking-tight text-amber-600">{{ $statKajian }}</p>
                <p class="mt-1.5 text-[11px] sm:text-xs font-bold uppercase tracking-widest text-slate-500">{{ $statKajianLabel }}</p>
                <div class="absolute -bottom-3 -right-3 w-14 h-14 rounded-full bg-amber-100/60"></div>
            </div>
            <div class="relative overflow-hidden text-center py-7 px-4 rounded-2xl border border-emerald-100 bg-gradient-to-br from-emerald-50 to-white shadow-xs hover:shadow-md hover:-translate-y-0.5 transition duration-200">
                <p class="text-3xl sm:text-4xl font-black tracking-tight text-emerald-700">{{ $statUkhuwah }}</p>
                <p class="mt-1.5 text-[11px] sm:text-xs font-bold uppercase tracking-widest text-slate-500">{{ $statUkhuwahLabel }}</p>
                <div class="absolute -bottom-3 -right-3 w-14 h-14 rounded-full bg-emerald-100/60"></div>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Pilar 1 -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-8 shadow-xs hover:border-emerald-300 hover:shadow-md transition duration-200 group">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-700 mb-6 group-hover:bg-emerald-600 group-hover:text-white transition duration-200">
                    <x-icon name="book-open-text" class="w-7 h-7" />
                </div>
                <h3 class="text-xl font-extrabold text-slate-900 mb-3">Tarbiyah & Karakter</h3>
                <p class="text-sm leading-relaxed text-slate-600">
                    Menanamkan akidah yang lurus, pemahaman ibadah yang benar, dan keteladanan akhlak mulia dalam tutur kata maupun tindakan sehari-hari.
                </p>
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-2 text-xs font-bold text-emerald-700">
                    <span>Kajian Tematik • Tahsin • Doa Bersama</span>
                </div>
            </div>

            <!-- Pilar 2 -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-8 shadow-xs hover:border-emerald-300 hover:shadow-md transition duration-200 group">
                <div class="w-14 h-14 rounded-2xl bg-teal-50 border border-teal-100 flex items-center justify-center text-teal-700 mb-6 group-hover:bg-teal-600 group-hover:text-white transition duration-200">
                    <x-icon name="heart-handshake" class="w-7 h-7" />
                </div>
                <h3 class="text-xl font-extrabold text-slate-900 mb-3">Ukhuwah Islamiyah</h3>
                <p class="text-sm leading-relaxed text-slate-600">
                    Menghubungkan antar-siswa dalam jalinan persaudaraan yang tulus, saling mengingatkan dalam kebaikan, dan saling merangkul tanpa sekat.
                </p>
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-2 text-xs font-bold text-teal-700">
                    <span>Mabit • Mentoring • Rihlah Kekeluargaan</span>
                </div>
            </div>

            <!-- Pilar 3 -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-8 shadow-xs hover:border-emerald-300 hover:shadow-md transition duration-200 group">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-700 mb-6 group-hover:bg-amber-600 group-hover:text-white transition duration-200">
                    <x-icon name="sparkles" class="w-7 h-7" />
                </div>
                <h3 class="text-xl font-extrabold text-slate-900 mb-3">Syiar & Manfaat Nyata</h3>
                <p class="text-sm leading-relaxed text-slate-600">
                    Menyebarkan inspirasi kebaikan melalui konten kreatif, aksi sosial peduli sesama, dan peran aktif dalam memakmurkan masjid sekolah.
                </p>
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-2 text-xs font-bold text-amber-700">
                    <span>Bakti Sosial • Infaq • Media Dakwah</span>
                </div>
            </div>
        </div>
    </section>

    <!-- WIDGET PIKET MASJID HARI INI (DIGNIFIED & RESPECTFUL DESIGN) -->
    @if(in_array($hariIni ?? '', ['Senin', 'Kamis']) && isset($piketHariIni) && $piketHariIni->count() > 0)
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="rounded-3xl border border-emerald-200/90 bg-gradient-to-br from-emerald-50/90 via-white to-teal-50/60 p-6 sm:p-8 shadow-sm">
            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center justify-between pb-6 border-b border-emerald-100">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-700 flex items-center justify-center text-white shadow-sm shadow-emerald-700/20">
                        <x-icon name="mosque" class="w-6 h-6" />
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-xl sm:text-2xl font-black text-slate-900">Jadwal Piket Masjid Hari Ini</h3>
                            <span class="rohis-badge-amber text-[10px]">{{ $hariIni }}</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 mt-0.5">
                            Jazakumullah khairan katsiran kepada rekan-rekan yang bertugas menjaga kebersihan & kenyamanan rumah Allah hari ini.
                        </p>
                    </div>
                </div>

                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 bg-white px-4 py-2 rounded-xl border border-emerald-200 shadow-xs">
                    <x-icon name="clock" class="w-3.5 h-3.5 text-emerald-600" />
                    Tugas: Sebelum & Sesudah Dzuhur
                </span>
            </div>

            <!-- Petugas Piket Columns -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-6">
                <!-- Ikhwan -->
                <div class="bg-white rounded-2xl p-5 border border-emerald-100 shadow-xs">
                    <div class="flex items-center gap-2.5 pb-3 mb-3 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-800">
                            <x-icon name="ikhwan" class="w-4 h-4" />
                        </div>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-sm">Petugas Ikhwan (Putra)</h4>
                            <p class="text-[11px] text-slate-500">Area Utama Sholat & Tempat Wudhu Pria</p>
                        </div>
                    </div>
                    <ul class="space-y-2 text-xs">
                        @forelse($piketHariIni->where('gender', 'Ikhwan') as $piket)
                            <li class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 border border-slate-100">
                                <x-icon name="check" class="w-3.5 h-3.5 text-emerald-600 shrink-0" />
                                <span class="font-semibold text-slate-800">{{ $piket->name }}</span>
                            </li>
                        @empty
                            <li class="text-slate-400 italic p-2">Tidak ada jadwal ikhwan hari ini</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Akhwat -->
                <div class="bg-white rounded-2xl p-5 border border-emerald-100 shadow-xs">
                    <div class="flex items-center gap-2.5 pb-3 mb-3 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-teal-100 flex items-center justify-center text-teal-800">
                            <x-icon name="akhwat" class="w-4 h-4" />
                        </div>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-sm">Petugas Akhwat (Putri)</h4>
                            <p class="text-[11px] text-slate-500">Area Mukena, Karpet Putri, & Tempat Wudhu</p>
                        </div>
                    </div>
                    <ul class="space-y-2 text-xs">
                        @forelse($piketHariIni->where('gender', 'Akhwat') as $piket)
                            <li class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 border border-slate-100">
                                <x-icon name="check" class="w-3.5 h-3.5 text-teal-600 shrink-0" />
                                <span class="font-semibold text-slate-800">{{ $piket->name }}</span>
                            </li>
                        @empty
                            <li class="text-slate-400 italic p-2">Tidak ada jadwal akhwat hari ini</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- AGENDA & KEGIATAN SECTION -->
    <section id="kegiatan" class="py-20 bg-slate-100/60 border-y border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div>
                    <span class="rohis-badge">
                        <x-icon name="calendar" class="w-3.5 h-3.5 text-emerald-600" />
                        Aktivitas & Program
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900 mt-2">
                        Kegiatan Terbaru & Mendatang
                    </h2>
                </div>
                <a href="{{ route('schedule.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-700 hover:text-emerald-800 transition">
                    <span>Lihat Seluruh Arsip Agenda</span>
                    <x-icon name="arrow-right" class="w-4 h-4" />
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-7">
                @if(isset($schedules) && $schedules->isNotEmpty())
                    @foreach($schedules->take(3) as $schedule)
                        <article class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-md hover:border-emerald-300 transition duration-200 flex flex-col justify-between">
                            <div>
                                <div class="relative h-48 w-full bg-slate-100 overflow-hidden">
                                    @if($schedule->image_path && Storage::disk('public')->exists($schedule->image_path))
                                        <img src="{{ asset('storage/' . $schedule->image_path) }}" alt="{{ $schedule->title }}" class="object-cover w-full h-full hover:scale-105 transition duration-300">
                                    @else
                                        <div class="flex flex-col h-full w-full items-center justify-center bg-emerald-50/70 text-emerald-600 gap-2">
                                            <x-icon name="image" class="w-8 h-8 opacity-40" />
                                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Dokumentasi Acara</span>
                                        </div>
                                    @endif

                                    <div class="absolute top-3 left-3">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide bg-white/95 backdrop-blur-sm text-slate-800 shadow-xs">
                                            <x-icon name="calendar" class="w-3 h-3 text-emerald-600" />
                                            {{ $schedule->event_date ? $schedule->event_date->format('d M Y') : 'Terjadwal' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="p-6">
                                    <h3 class="text-lg font-black text-slate-900 hover:text-emerald-700 transition">
                                        {{ $schedule->title }}
                                    </h3>
                                    <p class="mt-2 text-xs sm:text-sm text-slate-600 line-clamp-3 leading-relaxed">
                                        {{ $schedule->description }}
                                    </p>
                                </div>
                            </div>

                            <div class="p-6 pt-0">
                                <a href="{{ route('schedule.show', $schedule) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 hover:text-emerald-900 transition">
                                    <span>Lihat Rincian Kegiatan</span>
                                    <x-icon name="chevron-right" class="w-3.5 h-3.5" />
                                </a>
                            </div>
                        </article>
                    @endforeach
                @else
                    <!-- Fallback Cards (Clean, dignified) -->
                    @foreach([
                        ['title' => 'Kajian Akbar Mingguan', 'desc' => 'Pembahasan tema-tema kontemporer dan akhlak pelajar bersama ustadz tamu.'],
                        ['title' => 'Mabit (Malam Bina Iman & Taqwa)', 'desc' => 'Menghidupkan malam dengan qiyamul lail, muhasabah, dan kajian tafsir.'],
                        ['title' => 'Bakti Sosial & Santunan', 'desc' => 'Aksi nyata kepedulian sosial untuk masyarakat dan siswa yang membutuhkan.']
                    ] as $item)
                        <article class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-xs p-6 flex flex-col justify-between">
                            <div>
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center mb-4">
                                    <x-icon name="sparkles" class="w-5 h-5" />
                                </div>
                                <h3 class="text-lg font-black text-slate-900">{{ $item['title'] }}</h3>
                                <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">{{ $item['desc'] }}</p>
                            </div>
                            <div class="mt-6 pt-4 border-t border-slate-100 text-xs font-bold text-emerald-700">
                                Program Unggulan Rutin
                            </div>
                        </article>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- STRUKTUR PENGURUS HIGHLIGHT -->
    <section id="pengurus" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14 space-y-3">
            <span class="rohis-badge">
                <x-icon name="users" class="w-3.5 h-3.5 text-emerald-600" />
                Amanah & Kepemimpinan
            </span>
            <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900">
                Pengurus Rohis Darul Muttaqin
            </h2>
            <p class="text-sm sm:text-base text-slate-600">
                Siswa-siswi yang diamanahi untuk menggerakkan roda dakwah dan kegiatan kebaikan di lingkungan sekolah.
            </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @if(isset($officers) && $officers->isNotEmpty())
                @foreach($officers->take(4) as $officer)
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 text-center shadow-xs hover:border-emerald-300 hover:shadow-md transition duration-200 group">
                        <div class="relative w-24 h-24 sm:w-28 sm:h-28 mx-auto mb-4 overflow-hidden rounded-full border-2 border-emerald-100 p-1 bg-emerald-50/50">
                            @php
                                $offPhoto = $officer->photo_path ?? $officer->image_path;
                                $hasOffPhoto = filled($offPhoto) && Storage::disk('public')->exists($offPhoto);
                            @endphp
                            @if($hasOffPhoto)
                                <img src="{{ asset('storage/' . $offPhoto) }}" alt="{{ $officer->name }}" class="object-cover w-full h-full rounded-full group-hover:scale-105 transition duration-200">
                            @else
                                <div class="flex items-center justify-center w-full h-full rounded-full bg-emerald-100 text-emerald-700 font-extrabold text-2xl uppercase">
                                    {{ substr($officer->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900 leading-snug">{{ $officer->name }}</h3>
                        <p class="text-xs font-semibold text-emerald-700 mt-1">{{ $officer->position }}</p>
                    </div>
                @endforeach
            @else
                @foreach(['Ketua Umum', 'Wakil Ketua', 'Sekretaris', 'Bendahara'] as $jabatan)
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 text-center shadow-xs">
                        <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-extrabold text-xl">
                            <x-icon name="users" class="w-8 h-8 opacity-40" />
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Nama Pengurus</h3>
                        <p class="text-xs font-semibold text-emerald-700 mt-1">{{ $jabatan }}</p>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('officer.index') }}" class="cta-secondary">
                <x-icon name="users" class="w-4 h-4 text-emerald-700" />
                <span>Lihat Susunan Pengurus Lengkap</span>
                <x-icon name="arrow-right" class="w-4 h-4" />
            </a>
        </div>
    </section>

    <!-- GALERI DOKUMENTASI -->
    <section id="galeri" class="py-20 bg-slate-950 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14 space-y-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-950 text-emerald-400 border border-emerald-800">
                    <x-icon name="image" class="w-3.5 h-3.5" />
                    Galeri & Momen
                </span>
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                    Jejak Langkah & Kebersamaan
                </h2>
                <p class="text-sm sm:text-base text-slate-400">
                    Dokumentasi potret kegiatan, rihlah, dan kebersamaan keluarga besar Rohis Darul Muttaqin.
                </p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 lg:gap-6">
                @if(isset($galleries) && $galleries->isNotEmpty())
                    @foreach($galleries->take(6) as $gallery)
                        <div class="group relative aspect-square overflow-hidden rounded-2xl bg-slate-900 border border-slate-800">
                            <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title ?? 'Foto Kegiatan' }}" class="object-cover w-full h-full transition duration-500 group-hover:scale-105 opacity-85 group-hover:opacity-100">
                            @if($gallery->title)
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                                    <p class="text-xs font-bold text-white leading-snug">{{ $gallery->title }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    @for($i = 1; $i <= 3; $i++)
                        <div class="aspect-square rounded-2xl bg-slate-900 border border-slate-800/80 flex flex-col items-center justify-center text-slate-500 gap-2">
                            <x-icon name="image" class="w-8 h-8 opacity-30" />
                            <span class="text-xs font-bold">Dokumentasi Terpilih</span>
                        </div>
                    @endfor
                @endif
            </div>
        </div>
    </section>

    <!-- PENGUMUMAN -->
    @if($announcements->isNotEmpty())
    <section id="pengumuman" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <span class="rohis-badge">
                    <x-icon name="bell" class="w-3.5 h-3.5 text-emerald-600" />
                    Info Terbaru
                </span>
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900 mt-2">
                    Pengumuman Rohis
                </h2>
            </div>
            <a href="{{ route('announcement.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-700 hover:text-emerald-800 transition">
                <span>Lihat Semua Pengumuman</span>
                <x-icon name="arrow-right" class="w-4 h-4" />
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($announcements as $ann)
                <a href="{{ route('announcement.show', $ann->slug) }}"
                   class="group bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-md hover:border-emerald-300 transition duration-200 flex flex-col">
                    @if($ann->image_path && Storage::disk('public')->exists($ann->image_path))
                        <div class="h-44 overflow-hidden bg-slate-100">
                            <img src="{{ asset('storage/'.$ann->image_path) }}" alt="{{ $ann->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                    @else
                        <div class="h-44 bg-gradient-to-br from-emerald-50 to-teal-50 flex items-center justify-center text-emerald-300">
                            <x-icon name="megaphone" class="w-12 h-12 opacity-40" />
                        </div>
                    @endif
                    <div class="p-6 flex flex-col flex-1">
                        <p class="text-[11px] font-bold uppercase tracking-widest text-emerald-700 mb-2">
                            {{ $ann->created_at->translatedFormat('d F Y') }}
                        </p>
                        <h3 class="text-base font-extrabold text-slate-900 group-hover:text-emerald-700 transition leading-snug flex-1">
                            {{ $ann->title }}
                        </h3>
                        <p class="mt-3 text-sm text-slate-500 line-clamp-2 leading-relaxed">
                            {{ strip_tags($ann->content) }}
                        </p>
                        <div class="mt-4 inline-flex items-center gap-1 text-xs font-bold text-emerald-700">
                            Baca selengkapnya
                            <x-icon name="chevron-right" class="w-3.5 h-3.5" />
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    <!-- TANYA JAWAB (FAQ) INTERAKTIF -->
    <section id="faq" class="py-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14 space-y-3">
            <span class="rohis-badge">
                <x-icon name="help-circle" class="w-3.5 h-3.5 text-emerald-600" />
                Pertanyaan Populer
            </span>
            <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900">
                Tanya Jawab Seputar Rohis
            </h2>
            <p class="text-sm sm:text-base text-slate-600">
                Jawaban atas beberapa pertanyaan yang paling sering diajukan oleh calon anggota baru.
            </p>
        </div>

        <div class="space-y-4">
            @if(isset($faqs) && $faqs->isNotEmpty())
                @foreach($faqs as $faq)
                    <div x-data="{ open: false }" class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                        <button @click="open = !open" type="button" class="w-full flex items-center justify-between gap-4 p-5 sm:p-6 text-left focus:outline-none">
                            <h3 class="text-base font-extrabold text-slate-900">{{ $faq->question }}</h3>
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 shrink-0 transition duration-200" :class="{ 'rotate-180 bg-emerald-100 text-emerald-700': open }">
                                <x-icon name="chevron-down" class="w-4 h-4" />
                            </div>
                        </button>
                        <div x-show="open" x-cloak x-transition class="px-5 pb-6 sm:px-6 pt-0 text-sm leading-relaxed text-slate-600 border-t border-slate-50">
                            {{ $faq->answer }}
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Fallback FAQ -->
                <div x-data="{ open: true }" class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <button @click="open = !open" type="button" class="w-full flex items-center justify-between gap-4 p-5 sm:p-6 text-left focus:outline-none">
                        <h3 class="text-base font-extrabold text-slate-900">Apakah Rohis hanya untuk yang sudah pintar ilmu agama?</h3>
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 shrink-0 transition duration-200" :class="{ 'rotate-180 bg-emerald-100 text-emerald-700': open }">
                            <x-icon name="chevron-down" class="w-4 h-4" />
                        </div>
                    </button>
                    <div x-show="open" x-cloak x-transition class="px-5 pb-6 sm:px-6 pt-0 text-sm leading-relaxed text-slate-600 border-t border-slate-50">
                        Sama sekali tidak! Rohis adalah madrasah kebersamaan tempat kita semua belajar dari nol bersama-sama. Tidak ada syarat harus hafal Al-Qur'an atau menguasai bahasa Arab. Yang utama adalah niat yang tulus untuk menjadi pribadi yang lebih baik.
                    </div>
                </div>

                <div x-data="{ open: false }" class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <button @click="open = !open" type="button" class="w-full flex items-center justify-between gap-4 p-5 sm:p-6 text-left focus:outline-none">
                        <h3 class="text-base font-extrabold text-slate-900">Bagaimana cara mendaftar menjadi anggota baru?</h3>
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 shrink-0 transition duration-200" :class="{ 'rotate-180 bg-emerald-100 text-emerald-700': open }">
                            <x-icon name="chevron-down" class="w-4 h-4" />
                        </div>
                    </button>
                    <div x-show="open" x-cloak x-transition class="px-5 pb-6 sm:px-6 pt-0 text-sm leading-relaxed text-slate-600 border-t border-slate-50">
                        Cukup klik tombol "Daftar Anggota Baru" di bagian atas halaman ini, lalu lengkapi formulir pendaftaran singkat. Pengurus akan mengkonfirmasi dan mengundang teman-teman ke grup orientasi.
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- CALL TO ACTION BANNER -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-10">
        <div class="rounded-3xl bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 p-8 sm:p-12 text-white shadow-xl relative overflow-hidden">
            <div class="relative z-10 max-w-2xl space-y-4">
                <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-emerald-200 bg-emerald-950/60 px-3.5 py-1.5 rounded-full border border-emerald-700">
                    <x-icon name="crescent" class="w-3.5 h-3.5 text-amber-400" />
                    Mari Melangkah Bersama
                </span>
                <h2 class="text-2xl sm:text-4xl font-black tracking-tight text-white leading-tight">
                    Siap Menjadi Bagian dari Keluarga Rohis Darul Muttaqin?
                </h2>
                <p class="text-sm sm:text-base text-emerald-100 leading-relaxed">
                    Pintu kebaikan selalu terbuka lebar untukmu. Daftarkan dirimu hari ini dan rasakan indahnya bertumbuh dalam lingkaran persaudaraan yang positif.
                </p>
                <div class="pt-2">
                    <a href="{{ route('register.create') }}" class="inline-flex items-center gap-2 bg-white text-emerald-900 font-extrabold px-7 py-3.5 rounded-xl shadow-lg hover:bg-emerald-50 transition active:scale-[0.99]">
                        <x-icon name="user-plus" class="w-5 h-5 text-emerald-700" />
                        <span>Isi Formulir Pendaftaran Sekarang</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-public-layout>