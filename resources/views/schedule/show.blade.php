<x-public-layout :title="$schedule->title . ' - Rohis Darul Muttaqin'" :active="'kegiatan'">

    <section class="max-w-6xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
        <!-- Breadcrumb & Back button -->
        <div class="mb-8 flex items-center justify-between">
            <a href="{{ route('schedule.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-emerald-700 transition">
                <x-icon name="arrow-left" class="w-4 h-4" />
                <span>Kembali ke Semua Kegiatan</span>
            </a>
            <span class="rohis-badge-amber text-[10px]">
                {{ ucfirst($schedule->status) }}
            </span>
        </div>

        <div class="grid items-start gap-10 lg:grid-cols-12">
            <!-- Left: Image -->
            <div class="lg:col-span-6 overflow-hidden rounded-3xl border border-slate-200 bg-white p-2.5 shadow-sm">
                @if($schedule->image_path && Storage::disk('public')->exists($schedule->image_path))
                    <img src="{{ asset('storage/' . $schedule->image_path) }}" alt="{{ $schedule->title }}" class="h-[440px] w-full rounded-2xl object-cover">
                @else
                    <div class="flex h-[440px] w-full flex-col items-center justify-center rounded-2xl bg-emerald-50/60 text-emerald-700 gap-2">
                        <x-icon name="image" class="w-12 h-12 opacity-40" />
                        <span class="text-xs font-bold uppercase tracking-wider">Dokumentasi Acara</span>
                    </div>
                @endif
            </div>

            <!-- Right: Details -->
            <div class="lg:col-span-6 space-y-6">
                <div>
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100 mb-3">
                        <x-icon name="calendar" class="w-3.5 h-3.5" />
                        {{ $schedule->event_date ? $schedule->event_date->format('d F Y, H:i') . ' WIB' : 'Waktu menyusul' }}
                    </span>
                    <h1 class="text-2xl sm:text-4xl font-black tracking-tight text-slate-900 leading-tight">
                        {{ $schedule->title }}
                    </h1>
                </div>

                <!-- Info Grid -->
                <div class="bg-white rounded-2xl border border-slate-200 p-5 space-y-3 text-xs sm:text-sm shadow-xs">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600 shrink-0">
                            <x-icon name="map-pin" class="w-4 h-4 text-emerald-600" />
                        </div>
                        <div>
                            <span class="text-[11px] text-slate-400 font-bold uppercase tracking-wider block">Lokasi Pelaksanaan</span>
                            <span class="font-bold text-slate-800">{{ $schedule->location }}</span>
                        </div>
                    </div>

                    @if($schedule->speaker)
                        <div class="flex items-start gap-3 pt-3 border-t border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600 shrink-0">
                                <x-icon name="users" class="w-4 h-4 text-emerald-600" />
                            </div>
                            <div>
                                <span class="text-[11px] text-slate-400 font-bold uppercase tracking-wider block">Pembicara / Pemateri</span>
                                <span class="font-bold text-slate-800">{{ $schedule->speaker }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900 mb-3">Deskripsi & Catatan Kegiatan</h2>
                    <p class="whitespace-pre-line leading-relaxed text-slate-600 text-sm">
                        {{ $schedule->description }}
                    </p>
                </div>
            </div>
        </div>
    </section>

</x-public-layout>
