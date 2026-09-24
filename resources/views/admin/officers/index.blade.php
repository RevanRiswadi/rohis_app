<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-emerald-700">Pengurus</p>
                <h2 class="text-2xl font-extrabold leading-tight text-slate-900">
                    {{ __('Kelola Susunan Pengurus') }}
                </h2>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('officer.index') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-100">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M10 2.5a.75.75 0 0 1 .53.22l5.75 5.75a.75.75 0 0 1-.53 1.28H15v6.25A1.25 1.25 0 0 1 13.75 17h-7.5A1.25 1.25 0 0 1 5 15.75V9.75H4.25a.75.75 0 0 1-.53-1.28L9.47 2.72A.75.75 0 0 1 10 2.5Zm-3.5 7.25v6h7v-6H6.5Zm5.25-3.5L10 6.5l-1.75 1.75h3.5Z"/>
                    </svg>
                    Lihat Halaman Pengurus
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Tambah Pengurus -->
            <div class="overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-[0_20px_45px_rgba(15,23,42,0.05)]">
                <div class="mb-5 flex items-center justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Tambah Pengurus Baru</h3>
                        <p class="text-sm text-slate-500">Tambahkan susunan pengurus beserta foto dan jabatannya.</p>
                    </div>
                </div>

                <form action="{{ route('admin.officers.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                    @csrf
                    <div class="lg:col-span-2">
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama pengurus" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Jabatan</label>
                        <input type="text" name="position" value="{{ old('position') }}" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Contoh: Ketua Rohis" required>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Kelas / Jurusan (Opsional)</label>
                        <input type="text" name="class_major" value="{{ old('class_major') }}" placeholder="Contoh: XII PPLG 1" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>

                    <div class="lg:col-span-2">
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Foto Pengurus</label>
                        <input type="file" name="photo" accept="image/*" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-emerald-100 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-emerald-800 hover:file:bg-emerald-200">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Urutan Prioritas</label>
                        <input type="number" name="order_priority" value="{{ old('order_priority', 0) }}" min="0" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full rounded-xl bg-emerald-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-emerald-700 shadow-md shadow-emerald-600/20">Simpan Pengurus</button>
                    </div>
                </form>
            </div>

            <!-- Tabel Daftar Pengurus -->
            <div class="overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white shadow-[0_20px_45px_rgba(15,23,42,0.06)]">
                <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 via-white to-emerald-50 px-6 py-4">
                    <h3 class="text-lg font-black text-slate-900">Daftar Pengurus Rohis Darul Muttaqin</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-[0.12em] text-slate-600">
                            <tr>
                                <th class="px-6 py-3">Foto</th>
                                <th class="px-6 py-3">Nama</th>
                                <th class="px-6 py-3">Jabatan</th>
                                <th class="px-6 py-3">Kelas / Jurusan</th>
                                <th class="px-6 py-3 text-center">Urutan</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($officers as $officer)
                                <tr class="bg-white transition hover:bg-slate-50">
                                    <td class="px-6 py-3">
                                        @if($officer->photo_path && Storage::disk('public')->exists($officer->photo_path))
                                            <img src="{{ asset('storage/' . $officer->photo_path) }}" alt="{{ $officer->name }}" class="h-12 w-12 rounded-full object-cover border border-emerald-200 shadow-sm">
                                        @else
                                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100 text-emerald-800 font-black text-sm border border-emerald-200">
                                                {{ strtoupper(substr($officer->name, 0, 2)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold text-slate-900">{{ $officer->name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-800 border border-emerald-100">
                                            {{ $officer->position }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 font-medium">{{ $officer->class_major ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center font-bold text-slate-700">{{ $officer->order_priority }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex flex-wrap items-center justify-center gap-2">
                                            <a href="{{ route('admin.officers.show', $officer->id) }}" class="rounded-md bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-700 transition hover:bg-slate-200">Detail</a>
                                            <a href="{{ route('admin.officers.edit', $officer->id) }}" class="rounded-md bg-amber-500 px-3 py-1.5 text-xs font-bold text-white transition hover:bg-amber-600">Edit</a>
                                            <form action="{{ route('admin.officers.destroy', $officer->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data pengurus ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-md bg-red-600 px-3 py-1.5 text-xs font-bold text-white transition hover:bg-red-700">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-slate-500 font-medium">Belum ada data pengurus.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>