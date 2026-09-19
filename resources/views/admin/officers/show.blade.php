<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Detail Pengurus') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="mb-4 flex items-center justify-between gap-3">
                <a href="{{ route('admin.officers.index') }}" class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-bold text-gray-700 hover:border-emerald-200 hover:text-emerald-700">
                    ← Kembali
                </a>
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('officer.index') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-100">
                        Lihat Halaman Pengurus
                    </a>
                    <a href="{{ route('admin.officers.edit', $officer->id) }}" class="inline-flex items-center rounded-lg bg-amber-500 px-4 py-2 text-sm font-bold text-white transition hover:bg-amber-600">
                        Edit Data
                    </a>
                    <form action="{{ route('admin.officers.destroy', $officer->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengurus ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-red-700">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-100">
                <div class="border-b border-gray-100 px-6 py-5 flex items-center gap-5">
                    @if($officer->photo_path && Storage::disk('public')->exists($officer->photo_path))
                        <img src="{{ asset('storage/' . $officer->photo_path) }}" alt="{{ $officer->name }}" class="h-20 w-20 rounded-2xl object-cover border-2 border-emerald-200 shadow-md">
                    @else
                        <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-800 font-black text-2xl border-2 border-emerald-200">
                            {{ strtoupper(substr($officer->name, 0, 2)) }}
                        </div>
                    @endif
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-700">Pengurus Rohis</p>
                        <h3 class="text-2xl font-black text-gray-900">{{ $officer->name }}</h3>
                        <p class="text-sm font-bold text-emerald-800">{{ $officer->position }}</p>
                    </div>
                </div>

                <div class="grid gap-6 px-6 py-6 md:grid-cols-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500">Nama Lengkap</p>
                        <p class="mt-1 text-base font-bold text-gray-900">{{ $officer->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500">Jabatan</p>
                        <p class="mt-1 text-base font-bold text-gray-900">{{ $officer->position }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500">Kelas / Jurusan</p>
                        <p class="mt-1 text-base font-bold text-gray-900">{{ $officer->class_major ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500">Urutan Prioritas</p>
                        <p class="mt-1 text-base font-bold text-gray-900">{{ $officer->order_priority }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
