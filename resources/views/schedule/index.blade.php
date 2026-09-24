<x-public-layout :title="'Semua Agenda & Kegiatan - Rohis Darul Muttaqin'" :active="'kegiatan'">

    <!-- HEADER / HERO -->
    <section class="relative max-w-7xl mx-auto px-4 pt-12 pb-8 sm:px-6 lg:px-8 text-center">
        <div class="max-w-3xl mx-auto space-y-4">
            <span class="rohis-badge">
                <x-icon name="calendar" class="w-3.5 h-3.5 text-emerald-600" />
                Arsip & Agenda
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-slate-900">
                Semua Kegiatan Rohis Darul Muttaqin
            </h1>
            <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                Dokumentasi perjalanan dakwah, kajian rutin, bakti sosial, dan momen kebersamaan yang telah dan akan kami laksanakan.
            </p>
        </div>
    </section>

    <!-- SCHEDULES GRID -->
    <section class="max-w-7xl mx-auto px-4 pb-20 sm:px-6 lg:px-8">
        @if($schedules->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($schedules as $schedule)
                    <article class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-md hover:border-emerald-300 transition duration-200 flex flex-col justify-between">
                        <div>
                            <!-- Image / Thumbnail -->
                            <div class="relative h-56 w-full bg-slate-100 overflow-hidden">
                                @if($schedule->image_path && Storage::disk('public')->exists($schedule->image_path))
                                    <img src="{{ asset('storage/' . $schedule->image_path) }}" alt="{{ $schedule->title }}" class="w-full h-full object-cover hover:scale-105 transition duration-300">
                                @else
                                    <div class="flex flex-col h-full w-full items-center justify-center bg-emerald-50/70 text-emerald-700 gap-2">
                                        <x-icon name="image" class="w-8 h-8 opacity-40" />
                                        <span class="text-xs font-bold uppercase tracking-wider">Dokumentasi</span>
                                    </div>
                                @endif

                                <div class="absolute top-3 inset-x-3 flex items-center justify-between">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wide bg-white/95 backdrop-blur-sm text-emerald-800 shadow-xs">
                                        <x-icon name="check" class="w-3 h-3 text-emerald-600" />
                                        {{ ucfirst($schedule->status) }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-bold bg-slate-900/80 backdrop-blur-sm text-white shadow-xs">
                                        <x-icon name="calendar" class="w-3 h-3" />
                                        {{ $schedule->event_date ? $schedule->event_date->format('d M Y') : '-' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <h2 class="text-xl font-black text-slate-900 leading-snug hover:text-emerald-700 transition">
                                    {{ $schedule->title }}
                                </h2>
                                <p class="mt-2 text-xs sm:text-sm text-slate-600 line-clamp-3 leading-relaxed">
                                    {{ Str::limit($schedule->description, 140) }}
                                </p>

                                <div class="mt-4 pt-4 border-t border-slate-100 space-y-1.5 text-xs text-slate-600">
                                    <div class="flex items-center gap-2">
                                        <x-icon name="map-pin" class="w-3.5 h-3.5 text-emerald-600 shrink-0" />
                                        <span>{{ $schedule->location }}</span>
                                    </div>
                                    @if($schedule->speaker)
                                        <div class="flex items-center gap-2">
                                            <x-icon name="users" class="w-3.5 h-3.5 text-emerald-600 shrink-0" />
                                            <span>Pemateri: {{ $schedule->speaker }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="p-6 pt-0">
                            <a href="{{ route('schedule.show', $schedule) }}" class="cta-secondary w-full text-xs font-bold justify-center">
                                <span>Lihat Rincian Kegiatan</span>
                                <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="rounded-3xl border border-slate-200 bg-white p-12 text-center max-w-md mx-auto shadow-xs">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 mx-auto mb-4">
                    <x-icon name="calendar" class="w-7 h-7" />
                </div>
                <h3 class="text-lg font-black text-slate-900">Belum Ada Kegiatan</h3>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Saat ini belum ada dokumentasi agenda kegiatan yang ditampilkan.
                </p>
                <div class="mt-5">
                    <a href="{{ route('home') }}" class="cta-secondary text-xs">
                        <x-icon name="home" class="w-4 h-4" />
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>
            </div>
        @endif
    </section>

</x-public-layout>
