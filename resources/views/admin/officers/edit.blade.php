<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Data Pengurus') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-100 p-6">
                <div class="mb-6 flex items-center justify-between gap-3">
                    <div>
                        <h3 class="text-xl font-black text-gray-900">Ubah Pengurus</h3>
                        <p class="text-sm text-gray-500">Perbarui data, jabatan, dan foto pengurus.</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('admin.officers.index') }}" class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm font-bold text-gray-700 transition hover:bg-gray-100">
                            Kembali
                        </a>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.officers.update', $officer->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $officer->name) }}" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-700">Jabatan</label>
                        <input type="text" name="position" value="{{ old('position', $officer->position) }}" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-700">Kelas / Jurusan</label>
                        <input type="text" name="class_major" value="{{ old('class_major', $officer->class_major) }}" placeholder="Contoh: XII PPLG 1" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-700">Foto Pengurus</label>
                        @if($officer->photo_path && Storage::disk('public')->exists($officer->photo_path))
                            <div class="mb-3 flex items-center gap-4">
                                <img src="{{ asset('storage/' . $officer->photo_path) }}" alt="{{ $officer->name }}" class="h-20 w-20 rounded-2xl object-cover border-2 border-emerald-200 shadow-sm">
                                <span class="text-xs text-gray-500 font-medium">Foto saat ini. Unggah foto baru jika ingin mengganti.</span>
                            </div>
                        @endif
                        <input type="file" name="photo" accept="image/*" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-emerald-100 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-emerald-800 hover:file:bg-emerald-200">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-700">Urutan Prioritas</label>
                        <input type="number" name="order_priority" value="{{ old('order_priority', $officer->order_priority) }}" min="0" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>

                    <div class="flex items-center gap-3 pt-3">
                        <button type="submit" class="rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-700">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.officers.index') }}" class="rounded-xl bg-gray-200 px-6 py-3 text-sm font-bold text-gray-700 transition hover:bg-gray-300">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
