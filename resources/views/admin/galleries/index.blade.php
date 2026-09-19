<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-emerald-700">Galeri</p>
                <h2 class="text-2xl font-extrabold leading-tight text-slate-900">
                    {{ __('Kelola Galeri Kegiatan') }}
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
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-[0_20px_45px_rgba(15,23,42,0.05)]">
                <div class="mb-5 flex items-center justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Tambah Foto Kegiatan Baru</h3>
                        <p class="text-sm text-slate-500">Tambahkan foto kegiatan untuk ditampilkan di halaman publik.</p>
                    </div>
                </div>

                <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    @csrf
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Judul Foto / Kegiatan</label>
                        <input type="text" name="title" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">File Foto (Maks 2MB)</label>
                        <input type="file" name="image" accept="image/*" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 file:mr-4 file:rounded-lg file:border-0 file:bg-emerald-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-emerald-700 hover:file:bg-emerald-200" required>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full rounded-xl bg-emerald-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-emerald-700">Upload Foto</button>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white shadow-[0_20px_45px_rgba(15,23,42,0.06)]">
                <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 via-white to-emerald-50 px-6 py-4">
                    <h3 class="text-lg font-black text-slate-900">Koleksi Galeri</h3>
                </div>
                
                @if($galleries->count() > 0)
                    <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        @foreach($galleries as $gallery)
                            <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
                                <div class="aspect-[4/3] w-full overflow-hidden bg-slate-100">
                                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                </div>
                                <div class="p-4">
                                    <h4 class="truncate font-bold text-slate-900" title="{{ $gallery->title }}">{{ $gallery->title }}</h4>
                                    <div class="mt-2 flex items-center justify-between">
                                        @if($gallery->is_active)
                                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-bold text-emerald-700">Aktif</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-bold text-slate-700">Nonaktif</span>
                                        @endif
                                        <div class="flex items-center gap-2">
                                            <form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="title" value="{{ $gallery->title }}">
                                                <input type="hidden" name="is_active" value="{{ $gallery->is_active ? 0 : 1 }}">
                                                <button type="submit" class="text-xs font-bold {{ $gallery->is_active ? 'text-amber-600 hover:text-amber-700' : 'text-emerald-600 hover:text-emerald-700' }}" title="{{ $gallery->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                    {{ $gallery->is_active ? 'Sembunyikan' : 'Tampilkan' }}
                                                </button>
                                            </form>
                                            <span class="text-slate-300">|</span>
                                            <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-bold text-red-600 hover:text-red-700">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($galleries->hasPages())
                        <div class="border-t border-slate-200 p-4">
                            {{ $galleries->links() }}
                        </div>
                    @endif
                @else
                    <div class="px-6 py-10 text-center text-slate-500">
                        Belum ada foto di galeri.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
