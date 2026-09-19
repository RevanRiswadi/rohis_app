<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-emerald-700">Pendaftaran</p>
                <h2 class="text-2xl font-extrabold leading-tight text-slate-900">
                    {{ __('Kelola Pendaftaran Anggota') }}
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
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white shadow-[0_20px_45px_rgba(15,23,42,0.06)]">
                <div class="border-b border-slate-200 bg-gradient-to-r from-emerald-50 via-white to-lime-50 px-6 py-4">
                    <h3 class="text-lg font-black text-slate-900">Daftar Pendaftar Baru</h3>
                </div>
                <div class="overflow-x-auto p-0 text-gray-900">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-[0.12em] text-slate-600">
                            <tr>
                                <th class="px-6 py-3">Nama & Kelas</th>
                                <th class="px-6 py-3">NISN</th>
                                <th class="px-6 py-3">Divisi Pilihan</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrations as $reg)
                                <tr class="border-b border-slate-200 bg-white transition hover:bg-slate-50">
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-slate-900">{{ $reg->full_name }}</p>
                                        <p class="text-xs text-slate-500">{{ $reg->class }} - {{ $reg->major }}</p>
                                    </td>
                                    <td class="px-6 py-4">{{ $reg->nisn }}</td>
                                    <td class="px-6 py-4 font-medium text-emerald-700">{{ $reg->preferred_division }}</td>
                                    <td class="px-6 py-4">
                                        <!-- Logika Bahasa Indonesia untuk Status -->
                                        @php
                                            $statusText = 'Menunggu';
                                            $statusColor = 'bg-yellow-100 text-yellow-700 border border-yellow-200';
                                            
                                            if($reg->status == 'accepted') {
                                                $statusText = 'Diterima';
                                                $statusColor = 'bg-emerald-100 text-emerald-800 border border-emerald-200';
                                            } elseif($reg->status == 'rejected') {
                                                $statusText = 'Ditolak';
                                                $statusColor = 'bg-red-100 text-red-800 border border-red-200';
                                            }
                                        @endphp
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-extrabold shadow-sm {{ $statusColor }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex flex-wrap items-center justify-center gap-2">
                                            
                                            <!-- Logika Tombol Pintar -->
                                            @if($reg->status == 'pending')
                                                <form action="{{ route('admin.registrations.update', $reg->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="accepted">
                                                    <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-emerald-700 shadow hover:-translate-y-0.5">Terima</button>
                                                </form>
                                                <form action="{{ route('admin.registrations.update', $reg->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menolak pendaftar ini?');">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="rounded-lg bg-red-500 px-4 py-2 text-xs font-bold text-white transition hover:bg-red-600 shadow hover:-translate-y-0.5">Tolak</button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.registrations.update', $reg->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Kembalikan status pendaftar ini menjadi Menunggu?');">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="pending">
                                                    <button type="submit" class="rounded-lg bg-slate-200 px-4 py-2 text-xs font-bold text-slate-700 transition hover:bg-slate-300">Batalkan / Reset</button>
                                                </form>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500 bg-slate-50/50">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                            <p class="font-medium text-slate-500">Belum ada data pendaftar baru.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>