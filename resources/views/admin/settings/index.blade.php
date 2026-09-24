<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-emerald-700">Pengaturan</p>
                <h2 class="text-2xl font-extrabold leading-tight text-slate-900">
                    {{ __('Kelola Foto Hero Landing Page') }}
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
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-800">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-6 shadow-[0_20px_45px_rgba(15,23,42,0.05)] md:p-8">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-12 md:items-start">
                    <div class="md:col-span-5">
                        <h3 class="mb-3 text-base font-bold text-slate-900">Preview Foto Hero Saat Ini</h3>

                        @if($heroImage && Storage::disk('public')->exists($heroImage))
                            <div class="group relative aspect-square overflow-hidden rounded-[1.75rem] border border-slate-200 bg-slate-100 shadow-md">
                                <img src="{{ asset('storage/' . $heroImage) }}" alt="Foto Hero Landing Page" class="h-full w-full object-cover">
                                <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition duration-200 group-hover:opacity-100 p-4">
                                    <form action="{{ route('admin.settings.destroy') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini dan kembali ke tampilan placeholder?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-xs font-bold uppercase tracking-wider text-white shadow transition hover:bg-red-700">
                                            Hapus Foto &amp; Reset
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <p class="mt-2 text-center text-xs text-slate-500">Tampilan di halaman depan publik.</p>
                        @else
                            <div class="flex aspect-square flex-col items-center justify-center rounded-[1.75rem] border-2 border-dashed border-slate-300 bg-slate-50 p-8 text-center">
                                <svg class="mb-3 h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                </svg>
                                <span class="mb-1 text-xs font-semibold text-slate-600">Belum Ada Foto Terpasang</span>
                                <p class="text-xs text-slate-400">Tampilan di halaman publik menggunakan frame placeholder.</p>
                            </div>
                        @endif
                    </div>

                    <div class="md:col-span-7">
                        <h3 class="mb-3 text-base font-bold text-slate-900">Upload / Ganti Foto Hero</h3>
                        <p class="mb-6 text-sm text-slate-600">
                            Foto ini akan ditampilkan di kolom kanan Hero Section pada halaman depan (publik). Rekomendasi rasio gambar: <strong>1:1 (Square)</strong> atau <strong>4:3</strong> dengan resolusi minimal 800 x 800px.
                        </p>

                        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                            @csrf

                            <div>
                                <label class="mb-2 block text-sm font-bold text-slate-700">Pilih File Gambar Baru</label>
                                <input type="file" name="hero_image" accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full cursor-pointer rounded-lg border border-slate-300 bg-slate-50 p-3 text-sm text-slate-500 file:mr-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-emerald-700 hover:file:bg-emerald-100">
                                <p class="mt-1.5 text-xs text-slate-400">Format didukung: JPG, PNG, WEBP (Maksimal 3MB).</p>
                            </div>

                            <div class="grid gap-4 md:grid-cols-3">
                                <div>
                                    <label class="mb-2 block text-sm font-bold text-slate-700">Instagram</label>
                                    <input type="url" name="social_instagram" value="{{ old('social_instagram', $socialInstagram ?? 'https://instagram.com/rohis.sekolah') }}" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500" placeholder="https://instagram.com/youraccount">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-bold text-slate-700">No. WhatsApp Admin</label>
                                    <input type="text" name="social_whatsapp" value="{{ old('social_whatsapp', $socialWhatsapp ?? 'https://wa.me/6281234567890') }}" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Contoh: 081234567890 atau https://wa.me/6281234567890">
                                    <p class="mt-1 text-[11px] text-slate-500">Bisa diisi nomor (0812...) atau link WA. Otomatis dibuatkan link wa.me untuk membuka aplikasi WhatsApp.</p>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-bold text-slate-700">YouTube</label>
                                    <input type="url" name="social_youtube" value="{{ old('social_youtube', $socialYoutube ?? 'https://youtube.com/@rohis.sekolah') }}" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500" placeholder="https://youtube.com/@channelname">
                                </div>
                            </div>

                            <div class="flex items-center space-x-3 pt-2">
                                <button type="submit" class="rounded-lg bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-700">
                                    Simpan Pengaturan
                                </button>

                                <a href="{{ route('admin.dashboard') }}" class="rounded-lg bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- STATISTIK HOMEPAGE --}}
            <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-6 shadow-[0_20px_45px_rgba(15,23,42,0.05)] md:p-8">
                <div class="mb-6 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <i data-lucide="bar-chart-2" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900">Statistik Homepage</h3>
                        <p class="text-xs text-slate-500">4 angka yang tampil di bagian Tentang Kami. Kosongkan nilai untuk pakai data otomatis dari database.</p>
                    </div>
                </div>

                <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        {{-- Stat 1: Anggota --}}
                        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/50 p-4 space-y-3">
                            <div class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Kartu 1</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Nilai <span class="text-slate-400 font-normal">(kosong = auto)</span></label>
                                <input type="text" name="stat_anggota" value="{{ old('stat_anggota', $statAnggota) }}"
                                    placeholder="Contoh: 120+"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-bold text-slate-800 focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Label</label>
                                <input type="text" name="stat_anggota_label" value="{{ old('stat_anggota_label', $statAnggotaLabel) }}"
                                    placeholder="Anggota Aktif"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                        </div>

                        {{-- Stat 2: Program --}}
                        <div class="rounded-2xl border border-teal-100 bg-teal-50/50 p-4 space-y-3">
                            <div class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-teal-500"></span>
                                <p class="text-xs font-bold uppercase tracking-wider text-teal-700">Kartu 2</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Nilai <span class="text-slate-400 font-normal">(kosong = auto)</span></label>
                                <input type="text" name="stat_program" value="{{ old('stat_program', $statProgram) }}"
                                    placeholder="Contoh: 12+"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-bold text-slate-800 focus:border-teal-500 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Label</label>
                                <input type="text" name="stat_program_label" value="{{ old('stat_program_label', $statProgramLabel) }}"
                                    placeholder="Program Kegiatan"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:border-teal-500 focus:ring-teal-500">
                            </div>
                        </div>

                        {{-- Stat 3: Kajian --}}
                        <div class="rounded-2xl border border-amber-100 bg-amber-50/50 p-4 space-y-3">
                            <div class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                                <p class="text-xs font-bold uppercase tracking-wider text-amber-700">Kartu 3</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Nilai</label>
                                <input type="text" name="stat_kajian" value="{{ old('stat_kajian', $statKajian) }}"
                                    placeholder="Rutin"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-bold text-slate-800 focus:border-amber-500 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Label</label>
                                <input type="text" name="stat_kajian_label" value="{{ old('stat_kajian_label', $statKajianLabel) }}"
                                    placeholder="Kajian Mingguan"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:border-amber-500 focus:ring-amber-500">
                            </div>
                        </div>

                        {{-- Stat 4: Ukhuwah --}}
                        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/50 p-4 space-y-3">
                            <div class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-600"></span>
                                <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Kartu 4</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Nilai</label>
                                <input type="text" name="stat_ukhuwah" value="{{ old('stat_ukhuwah', $statUkhuwah) }}"
                                    placeholder="100%"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-bold text-slate-800 focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Label</label>
                                <input type="text" name="stat_ukhuwah_label" value="{{ old('stat_ukhuwah_label', $statUkhuwahLabel) }}"
                                    placeholder="Ukhuwah"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-700">
                            <i data-lucide="save" class="h-4 w-4"></i>
                            Simpan Statistik
                        </button>
                    </div>
                </form>
            </div>
            {{-- WHATSAPP NOTIFIKASI (FONNTE) --}}
            <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-6 shadow-[0_20px_45px_rgba(15,23,42,0.05)] md:p-8">
                <div class="mb-6 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <i data-lucide="message-circle" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900">Notifikasi WhatsApp Otomatis</h3>
                        <p class="text-xs text-slate-500">Admin mendapat notif WA setiap ada pendaftar baru. Pakai <a href="https://fonnte.com" target="_blank" class="text-emerald-600 hover:underline font-semibold">Fonnte</a> — daftar gratis, ~Rp 10/pesan.</p>
                    </div>
                </div>

                <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">
                                Fonnte API Token
                            </label>
                            <input type="text" name="fonnte_token"
                                value="{{ old('fonnte_token', $fonnteToken) }}"
                                placeholder="Paste token dari dashboard Fonnte"
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-mono focus:border-emerald-500 focus:ring-emerald-500">
                            <p class="mt-1.5 text-xs text-slate-400">Dapatkan di <strong>fonnte.com → Dashboard → Token</strong>.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">
                                Nomor WA Admin (penerima notif)
                            </label>
                            <input type="text" name="wa_admin_number"
                                value="{{ old('wa_admin_number', $waAdminNumber) }}"
                                placeholder="Contoh: 081234567890"
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <p class="mt-1.5 text-xs text-slate-400">Nomor HP admin yang akan menerima notif saat ada pendaftar baru.</p>
                        </div>
                    </div>

                    {{-- Status indikator --}}
                    <div class="flex items-center gap-3 rounded-xl border px-4 py-3 text-sm
                        {{ filled($fonnteToken) && filled($waAdminNumber)
                            ? 'border-emerald-200 bg-emerald-50 text-emerald-700'
                            : 'border-amber-200 bg-amber-50 text-amber-700' }}">
                        <i data-lucide="{{ filled($fonnteToken) && filled($waAdminNumber) ? 'check-circle-2' : 'alert-circle' }}"
                           class="h-4 w-4 shrink-0"></i>
                        @if(filled($fonnteToken) && filled($waAdminNumber))
                            <span><strong>Aktif</strong> — Notifikasi WA akan terkirim otomatis saat ada pendaftar baru.</span>
                        @else
                            <span><strong>Belum aktif</strong> — Isi token dan nomor admin untuk mengaktifkan notifikasi.</span>
                        @endif
                    </div>

                    <div class="pt-1">
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-700">
                            <i data-lucide="save" class="h-4 w-4"></i>
                            Simpan Konfigurasi WA
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
