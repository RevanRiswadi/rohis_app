<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-extrabold leading-tight text-gray-900">
            {{ __('Edit Dokumentasi Kegiatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-[2rem] border border-gray-100 bg-white p-6 shadow-sm md:p-8">
                <div class="mb-6 flex items-center justify-between gap-3">
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">Ubah Kegiatan</h3>
                        <p class="text-sm text-gray-500">Perbarui detail dan foto kegiatan yang sudah ada.</p>
                    </div>
                    <a href="{{ route('admin.schedules.index') }}" class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm font-bold text-gray-700 transition hover:bg-gray-100">
                        Kembali ke Daftar
                    </a>
                </div>

                <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    @csrf
                    @method('PUT')

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-bold text-gray-700">Judul Kegiatan</label>
                        <input type="text" name="title" value="{{ old('title', $schedule->title) }}" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-bold text-gray-700">Deskripsi</label>
                        <textarea name="description" rows="4" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500" required>{{ old('description', $schedule->description) }}</textarea>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-700">Tanggal Kegiatan</label>
                        <input type="datetime-local" name="event_date" value="{{ old('event_date', $schedule->event_date ? $schedule->event_date->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-700">Lokasi</label>
                        <input type="text" name="location" value="{{ old('location', $schedule->location) }}" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-700">Pembicara / Narasumber</label>
                        <input type="text" name="speaker" value="{{ old('speaker', $schedule->speaker) }}" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Opsional">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-700">Status</label>
                        <select name="status" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="upcoming" {{ old('status', $schedule->status) == 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                            <option value="completed" {{ old('status', $schedule->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ old('status', $schedule->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-bold text-gray-700">Ganti Foto Dokumentasi</label>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full rounded-xl border border-gray-200 bg-gray-50 p-3 text-sm text-gray-500 file:mr-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-sm file:font-bold file:text-emerald-700 hover:file:bg-emerald-100">

                        @if($schedule->image_path && Storage::disk('public')->exists($schedule->image_path))
                            <div class="mt-4">
                                <img src="{{ asset('storage/' . $schedule->image_path) }}" alt="{{ $schedule->title }}" class="h-28 w-40 rounded-xl border border-gray-200 object-cover">
                            </div>
                        @endif
                    </div>

                    <div class="md:col-span-2 flex items-center gap-3">
                        <button type="submit" class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-700">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.schedules.index') }}" class="rounded-xl bg-gray-200 px-5 py-3 text-sm font-bold text-gray-700 transition hover:bg-gray-300">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
