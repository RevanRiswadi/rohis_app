<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-emerald-700">Pendaftaran</p>
                <h2 class="text-2xl font-extrabold leading-tight text-slate-900">
                    {{ __('Edit Data Pendaftar') }}
                </h2>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-bold transition border rounded-full border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100">
                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M10 2.5a.75.75 0 0 1 .53.22l5.75 5.75a.75.75 0 0 1-.53 1.28H15v6.25A1.25 1.25 0 0 1 13.75 17h-7.5A1.25 1.25 0 0 1 5 15.75V9.75H4.25a.75.75 0 0 1-.53-1.28L9.47 2.72A.75.75 0 0 1 10 2.5Zm-3.5 7.25v6h7v-6H6.5Zm5.25-3.5L10 6.5l-1.75 1.75h3.5Z"/>
                    </svg>
                    Buka Website
                </a>
                <a href="{{ route('admin.registrations.index') }}" class="px-4 py-2 text-sm font-bold transition border rounded-full border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl px-4 mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-[0_30px_80px_rgba(15,23,42,0.08)]">
                <div class="px-6 py-6 border-b border-slate-200 bg-gradient-to-r from-emerald-50 via-white to-lime-50 md:px-8">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-emerald-700">Pendaftaran</p>
                            <h3 class="mt-2 text-2xl font-extrabold text-slate-900">Ubah Data Pendaftar</h3>
                        </div>

                        <span class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-100 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.16em] text-emerald-700">
                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                            {{ ucfirst($registration->status) }}
                        </span>
                    </div>
                </div>

                <div class="grid gap-0 lg:grid-cols-[1.2fr_0.8fr]">
                    <div class="p-6 md:p-8">
                        <form action="{{ route('admin.registrations.update', $registration->id) }}" method="POST" class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">Nama Lengkap</label>
                                <input type="text" name="full_name" value="{{ old('full_name', $registration->full_name) }}" class="w-full px-4 py-3 border shadow-sm rounded-2xl border-slate-200 bg-slate-50 text-slate-900 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" required>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">NISN</label>
                                <input type="text" name="nisn" value="{{ old('nisn', $registration->nisn) }}" class="w-full px-4 py-3 border shadow-sm rounded-2xl border-slate-200 bg-slate-50 text-slate-900 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" required>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">Kelas</label>
                                <input type="text" name="class" value="{{ old('class', $registration->class) }}" class="w-full px-4 py-3 border shadow-sm rounded-2xl border-slate-200 bg-slate-50 text-slate-900 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" required>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">Jurusan</label>
                                <input type="text" name="major" value="{{ old('major', $registration->major) }}" class="w-full px-4 py-3 border shadow-sm rounded-2xl border-slate-200 bg-slate-50 text-slate-900 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" required>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">No. WhatsApp</label>
                                <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $registration->whatsapp_number) }}" class="w-full px-4 py-3 border shadow-sm rounded-2xl border-slate-200 bg-slate-50 text-slate-900 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" required>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">Divisi Pilihan</label>
                                <input type="text" name="preferred_division" value="{{ old('preferred_division', $registration->preferred_division) }}" class="w-full px-4 py-3 border shadow-sm rounded-2xl border-slate-200 bg-slate-50 text-slate-900 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" required>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block mb-2 text-sm font-bold text-slate-700">Alasan Bergabung</label>
                                <textarea name="reason" rows="4" class="w-full px-4 py-3 border shadow-sm rounded-2xl border-slate-200 bg-slate-50 text-slate-900 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" required>{{ old('reason', $registration->reason) }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block mb-2 text-sm font-bold text-slate-700">Status</label>
                                <select name="status" class="w-full px-4 py-3 border shadow-sm rounded-2xl border-slate-200 bg-slate-50 text-slate-900 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                    <option value="pending" {{ old('status', $registration->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ old('status', $registration->status) == 'accepted' ? 'selected' : '' }}>Diterima</option>
                                    <option value="rejected" {{ old('status', $registration->status) == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>

                            <div class="flex items-center gap-3 mt-2 md:col-span-2">
                                <button type="submit" class="inline-flex items-center justify-center px-5 py-3 text-sm font-bold text-white transition shadow-lg rounded-2xl bg-emerald-600 shadow-emerald-600/20 hover:bg-emerald-700">
                                    Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.registrations.index') }}" class="inline-flex items-center justify-center px-5 py-3 text-sm font-bold transition rounded-2xl bg-slate-200 text-slate-700 hover:bg-slate-300">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>

                    <aside class="p-6 border-t border-slate-200 bg-slate-50 md:p-8 lg:border-l lg:border-t-0">
                        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm">
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500">Ringkasan</p>
                            <h4 class="mt-3 text-xl font-extrabold text-slate-900">{{ $registration->full_name }}</h4>

                            <dl class="mt-5 space-y-3 text-sm">
                                <div class="flex items-center justify-between gap-3 px-3 py-2 rounded-xl bg-slate-50">
                                    <dt class="font-medium text-slate-500">NISN</dt>
                                    <dd class="font-bold text-slate-800">{{ $registration->nisn }}</dd>
                                </div>
                                <div class="flex items-center justify-between gap-3 px-3 py-2 rounded-xl bg-slate-50">
                                    <dt class="font-medium text-slate-500">Kelas</dt>
                                    <dd class="font-bold text-slate-800">{{ $registration->class }}</dd>
                                </div>
                                <div class="flex items-center justify-between gap-3 px-3 py-2 rounded-xl bg-slate-50">
                                    <dt class="font-medium text-slate-500">Jurusan</dt>
                                    <dd class="font-bold text-slate-800">{{ $registration->major }}</dd>
                                </div>
                                <div class="flex items-center justify-between gap-3 px-3 py-2 rounded-xl bg-slate-50">
                                    <dt class="font-medium text-slate-500">Divisi</dt>
                                    <dd class="font-bold text-slate-800">{{ $registration->preferred_division }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="mt-5 rounded-[1.75rem] border border-emerald-100 bg-emerald-50 p-5">
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-700">Catatan</p>
                            <p class="mt-3 text-sm leading-relaxed text-slate-600">
                                Periksa kembali data pendaftar sebelum mengubah status agar proses seleksi tetap akurat dan konsisten.
                            </p>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
