<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Detail Pendaftar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="mb-4 flex items-center justify-between gap-3">
                <a href="{{ route('admin.registrations.index') }}" class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-bold text-gray-700 hover:border-emerald-200 hover:text-emerald-700">
                    ← Kembali
                </a>
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-100">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M10 2.5a.75.75 0 0 1 .53.22l5.75 5.75a.75.75 0 0 1-.53 1.28H15v6.25A1.25 1.25 0 0 1 13.75 17h-7.5A1.25 1.25 0 0 1 5 15.75V9.75H4.25a.75.75 0 0 1-.53-1.28L9.47 2.72A.75.75 0 0 1 10 2.5Zm-3.5 7.25v6h7v-6H6.5Zm5.25-3.5L10 6.5l-1.75 1.75h3.5Z"/>
                        </svg>
                        Buka Website
                    </a>
                    <a href="{{ route('admin.registrations.edit', $registration->id) }}" class="inline-flex items-center rounded-lg bg-amber-500 px-4 py-2 text-sm font-bold text-white transition hover:bg-amber-600">
                        Edit Data
                    </a>
                    <form action="{{ route('admin.registrations.destroy', $registration->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data pendaftar ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-red-700">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-100">
                <div class="border-b border-gray-100 px-6 py-5">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-500">Pendaftar</p>
                            <h3 class="mt-2 text-2xl font-black text-gray-900">{{ $registration->full_name }}</h3>
                        </div>
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wide
                            {{ strtolower((string) $registration->status) == 'pending' ? 'bg-yellow-100 text-yellow-700' : (strtolower((string) $registration->status) == 'accepted' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }}">
                            {{ ucfirst(strtolower((string) $registration->status)) }}
                        </span>
                    </div>
                </div>

                <div class="grid gap-6 px-6 py-6 md:grid-cols-2">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500">NISN</p>
                        <p class="mt-2 text-base font-bold text-gray-900">{{ $registration->nisn }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500">WhatsApp</p>
                        <p class="mt-2 text-base font-bold text-gray-900">{{ $registration->whatsapp_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500">Kelas</p>
                        <p class="mt-2 text-base font-bold text-gray-900">{{ $registration->class }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500">Jurusan</p>
                        <p class="mt-2 text-base font-bold text-gray-900">{{ $registration->major }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500">Divisi Pilihan</p>
                        <p class="mt-2 text-base font-bold text-gray-900">{{ $registration->preferred_division }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500">Tanggal Daftar</p>
                        <p class="mt-2 text-base font-bold text-gray-900">{{ $registration->created_at?->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <div class="border-t border-gray-100 px-6 py-6">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500">Alasan Bergabung</p>
                    <p class="mt-3 whitespace-pre-line text-base leading-7 text-gray-700">{{ $registration->reason }}</p>
                </div>

                @if(strtolower((string) $registration->status) === 'pending')
                    <div class="flex flex-col gap-3 border-t border-gray-100 px-6 py-6 md:flex-row">
                        <form action="{{ route('admin.registrations.update', $registration->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="accepted">
                            <button type="submit" class="inline-flex items-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-blue-700">Terima Pendaftar</button>
                        </form>
                        <form action="{{ route('admin.registrations.update', $registration->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="inline-flex items-center rounded-xl bg-red-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-red-700">Tolak Pendaftar</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
