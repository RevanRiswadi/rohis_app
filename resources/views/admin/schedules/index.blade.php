<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-emerald-700">Dokumentasi</p>
                <h2 class="text-2xl font-extrabold leading-tight text-slate-900">
                    {{ __('Dokumentasi Kegiatan Rohis Darul Muttaqin') }}
                </h2>
            </div>
            <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-100">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10 2.5a.75.75 0 0 1 .53.22l5.75 5.75a.75.75 0 0 1-.53 1.28H15v6.25A1.25 1.25 0 0 1 13.75 17h-7.5A1.25 1.25 0 0 1 5 15.75V9.75H4.25a.75.75 0 0 1-.53-1.28L9.47 2.72A.75.75 0 0 1 10 2.5Zm-3.5 7.25v6h7v-6H6.5Zm5.25-3.5L10 6.5l-1.75 1.75h3.5Z"/>
                </svg>
                Buka Website
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-6 shadow-[0_20px_45px_rgba(15,23,42,0.05)] md:p-8">
                <div class="mb-6 flex items-center justify-between gap-3">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">Tambah Kegiatan Baru</h3>
                        <p class="text-sm text-slate-500">Buat dokumentasi kegiatan yang akan muncul di halaman publik.</p>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-bold text-slate-700 transition hover:bg-slate-100">
                        Kembali ke Dashboard
                    </a>
                </div>

                <form action="{{ route('admin.schedules.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    @csrf

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-bold text-slate-700">Judul Kegiatan</label>
                        <input type="text" name="title" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-bold text-slate-700">Deskripsi</label>
                        <textarea name="description" rows="4" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500" required></textarea>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700">Tanggal Kegiatan</label>
                        <input type="datetime-local" name="event_date" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700">Lokasi</label>
                        <input type="text" name="location" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700">Pembicara / Narasumber</label>
                        <input type="text" name="speaker" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Opsional">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700">Status</label>
                        <select name="status" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="upcoming">Akan Datang</option>
                            <option value="completed">Selesai</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-bold text-slate-700">Foto Dokumentasi</label>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full rounded-xl border border-slate-200 bg-slate-50 p-3 text-sm text-slate-500 file:mr-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-sm file:font-bold file:text-emerald-700 hover:file:bg-emerald-100">
                    </div>

                    <div class="md:col-span-2 flex items-end">
                        <button type="submit" class="w-full rounded-xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-700 md:w-auto">
                            Simpan Kegiatan
                        </button>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-6 shadow-[0_20px_45px_rgba(15,23,42,0.05)] md:p-8">
                <div class="mb-6">
                    <h3 class="text-xl font-extrabold text-slate-900">Daftar Dokumentasi Kegiatan</h3>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                    @forelse($schedules as $schedule)
                        <div class="overflow-hidden rounded-[1.5rem] border border-slate-200 bg-slate-50">
                            @if($schedule->image_path && Storage::disk('public')->exists($schedule->image_path))
                                <img src="{{ asset('storage/' . $schedule->image_path) }}" alt="{{ $schedule->title }}" class="h-48 w-full object-cover">
                            @else
                                <div class="flex h-48 w-full items-center justify-center bg-gradient-to-br from-emerald-100 via-emerald-50 to-slate-200 text-sm font-extrabold uppercase tracking-[0.2em] text-slate-600">
                                    Tanpa Foto
                                </div>
                            @endif

                            <div class="space-y-3 p-4">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-emerald-600">{{ ucfirst($schedule->status) }}</p>
                                    <h4 class="mt-2 text-lg font-extrabold text-slate-900">{{ $schedule->title }}</h4>
                                </div>

                                <p class="line-clamp-3 text-sm leading-relaxed text-slate-600">{{ $schedule->description }}</p>

                                <div class="space-y-1 text-xs text-slate-500">
                                    <p><strong>Tanggal:</strong> {{ $schedule->event_date ? $schedule->event_date->format('d M Y, H:i') : '-' }}</p>
                                    <p><strong>Lokasi:</strong> {{ $schedule->location }}</p>
                                    @if($schedule->speaker)
                                        <p><strong>Pembicara:</strong> {{ $schedule->speaker }}</p>
                                    @endif
                                </div>

                                <div class="flex gap-2 pt-2">
                                    <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="flex-1 rounded-xl bg-amber-500 px-3 py-2.5 text-center text-sm font-bold text-white transition hover:bg-amber-600">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus dokumentasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full rounded-xl bg-red-600 px-3 py-2.5 text-sm font-bold text-white transition hover:bg-red-700">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-[1.5rem] border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500 md:col-span-2 xl:col-span-3">
                            Belum ada dokumentasi kegiatan yang ditambahkan.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
