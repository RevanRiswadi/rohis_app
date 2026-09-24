<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-extrabold leading-tight text-gray-900">
            {{ __('Dashboard Admin Rohis Darul Muttaqin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-[2rem] border border-emerald-200 bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-500 p-8 text-white shadow-xl shadow-emerald-600/20">
                <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-[0.18em] text-emerald-100">Panel Admin</p>
                        <h3 class="mt-3 text-3xl font-black tracking-tight">Selamat Datang, Admin!</h3>
                        <p class="mt-3 max-w-2xl text-sm text-emerald-50 md:text-base">
                            Kelola pendaftaran, susunan pengurus, dokumentasi kegiatan, dan foto hero publik dari satu dashboard.
                        </p>
                        <div class="mt-5 flex flex-wrap gap-3">
                            <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-black text-emerald-700 shadow-lg shadow-emerald-900/10 transition hover:bg-emerald-50">
                                <i data-lucide="house" class="h-4 w-4"></i>
                                Preview Website
                            </a>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur-sm">
                        <div class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-100">Pending</div>
                        <div class="mt-2 text-4xl font-black">{{ $pendingRegistrations ?? 0 }}</div>
                        <div class="text-sm text-emerald-100">Pendaftaran baru</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                        <i data-lucide="clipboard-list" class="h-6 w-6"></i>
                    </div>
                    <h4 class="text-xl font-extrabold text-slate-900">Pendaftaran</h4>
                    <div class="mt-4 grid grid-cols-3 gap-2 text-center text-xs font-bold">
                        <div class="rounded-xl bg-yellow-50 p-2 text-yellow-700">
                            <div class="text-lg">{{ $statusCounts['pending'] ?? 0 }}</div>
                            <div>Pending</div>
                        </div>
                        <div class="rounded-xl bg-green-50 p-2 text-green-700">
                            <div class="text-lg">{{ $statusCounts['accepted'] ?? 0 }}</div>
                            <div>Terima</div>
                        </div>
                        <div class="rounded-xl bg-red-50 p-2 text-red-700">
                            <div class="text-lg">{{ $statusCounts['rejected'] ?? 0 }}</div>
                            <div>Tolak</div>
                        </div>
                    </div>
                    <a href="{{ route('admin.registrations.index') }}" class="mt-5 inline-flex items-center text-sm font-bold text-blue-600">
                        Kelola sekarang <span class="ml-2 transition group-hover:translate-x-1">→</span>
                    </a>
                </div>

                <a href="{{ route('admin.officers.index') }}" class="group rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60 transition duration-200 hover:-translate-y-1 hover:shadow-xl">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-violet-50 text-violet-600">
                        <i data-lucide="users-round" class="h-6 w-6"></i>
                    </div>
                    <h4 class="text-xl font-extrabold text-slate-900">Pengurus</h4>
                    <p class="mt-3 text-sm leading-relaxed text-slate-500">Tambah, ubah, atau hapus susunan pengurus Rohis.</p>
                    <div class="mt-5 inline-flex items-center text-sm font-bold text-violet-600">
                        Kelola sekarang <span class="ml-2 transition group-hover:translate-x-1">→</span>
                    </div>
                </a>

                <a href="{{ route('admin.schedules.index') }}" class="group rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60 transition duration-200 hover:-translate-y-1 hover:shadow-xl">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                        <i data-lucide="book-image" class="h-6 w-6"></i>
                    </div>
                    <h4 class="text-xl font-extrabold text-slate-900">Kegiatan & Agenda</h4>
                    <p class="mt-3 text-sm leading-relaxed text-slate-500">Tambah kegiatan, foto, dan dokumentasi acara Rohis.</p>
                    <div class="mt-5 inline-flex items-center text-sm font-bold text-emerald-600">
                        Kelola sekarang <span class="ml-2 transition group-hover:translate-x-1">→</span>
                    </div>
                </a>

                <a href="{{ route('admin.settings.index') }}" class="group rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60 transition duration-200 hover:-translate-y-1 hover:shadow-xl">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                        <i data-lucide="image" class="h-6 w-6"></i>
                    </div>
                    <h4 class="text-xl font-extrabold text-slate-900">Foto Hero</h4>
                    <p class="mt-3 text-sm leading-relaxed text-slate-500">Upload, ganti, atau atur gambar utama di halaman publik.</p>
                    <div class="mt-5 inline-flex items-center text-sm font-bold text-amber-600">
                        Kelola sekarang <span class="ml-2 transition group-hover:translate-x-1">→</span>
                    </div>
                </a>

                <a href="{{ route('admin.members.index') }}" class="group rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60 transition duration-200 hover:-translate-y-1 hover:shadow-xl">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-50 text-cyan-600">
                        <i data-lucide="user-check" class="h-6 w-6"></i>
                    </div>
                    <h4 class="text-xl font-extrabold text-slate-900">Anggota Resmi</h4>
                    <p class="mt-3 text-sm leading-relaxed text-slate-500">Lihat dan kelola anggota yang pendaftarannya telah diterima.</p>
                    <div class="mt-5 inline-flex items-center text-sm font-bold text-cyan-600">
                        Kelola sekarang <span class="ml-2 transition group-hover:translate-x-1">→</span>
                    </div>
                </a>

                <a href="{{ route('admin.galleries.index') }}" class="group rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60 transition duration-200 hover:-translate-y-1 hover:shadow-xl">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-50 text-pink-600">
                        <i data-lucide="images" class="h-6 w-6"></i>
                    </div>
                    <h4 class="text-xl font-extrabold text-slate-900">Galeri Foto</h4>
                    <p class="mt-3 text-sm leading-relaxed text-slate-500">Upload dan kelola foto kegiatan yang tampil di website utama.</p>
                    <div class="mt-5 inline-flex items-center text-sm font-bold text-pink-600">
                        Kelola sekarang <span class="ml-2 transition group-hover:translate-x-1">→</span>
                    </div>
                </a>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                <div class="mb-5 flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-emerald-700">Dokumentasi</p>
                        <h3 class="mt-2 text-2xl font-black text-slate-900">Dokumentasi Terbaru</h3>
                    </div>
                    <a href="{{ route('admin.schedules.index') }}" class="inline-flex items-center rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-700 transition hover:bg-emerald-100">
                        Kelola semua
                    </a>
                </div>

                @if($recentSchedules->isNotEmpty())
                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        @foreach($recentSchedules as $schedule)
                            <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4">
                                <div class="mb-3 flex items-center justify-between gap-3">
                                    <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-black uppercase tracking-[0.15em] text-emerald-700">
                                        {{ ucfirst($schedule->status) }}
                                    </span>
                                    <span class="text-xs font-semibold text-slate-500">
                                        {{ $schedule->event_date ? $schedule->event_date->format('d M Y') : '-' }}
                                    </span>
                                </div>
                                <h4 class="text-lg font-extrabold text-slate-900">{{ $schedule->title }}</h4>
                                <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-slate-600">{{ $schedule->description }}</p>
                                <div class="mt-3 space-y-1 text-sm text-slate-600">
                                    <p><strong class="font-bold text-slate-800">Lokasi:</strong> {{ $schedule->location }}</p>
                                    @if($schedule->speaker)
                                        <p><strong class="font-bold text-slate-800">Pembicara:</strong> {{ $schedule->speaker }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 py-8 text-center text-sm text-slate-500">
                        Belum ada dokumentasi kegiatan yang dibuat.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>