<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-emerald-700">Pendaftaran</p>
                <h2 class="text-2xl font-extrabold leading-tight text-slate-900">
                    {{ __('Kelola Pendaftaran Anggota') }}
                </h2>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.registrations.export') }}" class="inline-flex items-center gap-2 rounded-full bg-emerald-600 px-4 py-2 text-sm font-bold text-white shadow-md shadow-emerald-600/20 transition hover:bg-emerald-700 active:scale-95">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Data (Excel)
                </a>
                <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-100">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M10 2.5a.75.75 0 0 1 .53.22l5.75 5.75a.75.75 0 0 1-.53 1.28H15v6.25A1.25 1.25 0 0 1 13.75 17h-7.5A1.25 1.25 0 0 1 5 15.75V9.75H4.25a.75.75 0 0 1-.53-1.28L9.47 2.72A.75.75 0 0 1 10 2.5Zm-3.5 7.25v6h7v-6H6.5Zm5.25-3.5L10 6.5l-1.75 1.75h3.5Z"/>
                    </svg>
                    Buka Website
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @php
                $activeStatus = in_array($status ?? 'all', ['all', 'pending', 'accepted', 'rejected'], true) ? ($status ?? 'all') : 'all';
                $filterItems = [
                    ['value' => 'all', 'label' => 'Semua'],
                    ['value' => 'pending', 'label' => 'Pending'],
                    ['value' => 'accepted', 'label' => 'Diterima'],
                    ['value' => 'rejected', 'label' => 'Ditolak'],
                ];
            @endphp

            <div class="mb-6 rounded-[1.75rem] border border-slate-200 bg-white p-4 shadow-[0_20px_45px_rgba(15,23,42,0.05)]">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex flex-wrap gap-2">
                        @foreach($filterItems as $item)
                            <a href="{{ route('admin.registrations.index', ['status' => $item['value'] === 'all' ? null : $item['value']]) }}"
                               class="rounded-full px-4 py-2 text-sm font-bold transition {{ $activeStatus === $item['value'] ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'border border-slate-200 bg-slate-50 text-slate-700 hover:border-emerald-200 hover:text-emerald-700' }}">
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </div>

                    <a href="{{ route('admin.registrations.export') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-emerald-700 shadow-md shadow-emerald-600/20">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export Excel (CSV)
                    </a>
                </div>
            </div>

            <div class="overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white shadow-[0_20px_45px_rgba(15,23,42,0.06)]">
                <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 via-white to-emerald-50 px-6 py-4">
                    <h3 class="text-lg font-black text-slate-900">Daftar Pendaftar</h3>
                </div>
                <div class="overflow-x-auto text-gray-900">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-[0.12em] text-slate-600">
                            <tr>
                                <th class="px-6 py-3">Nama & Kelas</th>
                                <th class="px-6 py-3">NISN</th>
                                <th class="px-6 py-3">No. WhatsApp</th>
                                <th class="px-6 py-3">Divisi Pilihan</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrations as $reg)
                                @php
                                    $status = strtolower((string) $reg->status);
                                    $cleanWa = preg_replace('/[^0-9]/', '', $reg->whatsapp_number);
                                    $waNumber = preg_replace('/^0/', '62', $cleanWa);
                                    $waMessage = rawurlencode("Assalamu'alaikum kak {$reg->full_name}, kami dari panitia Rohis Sekolah...");
                                @endphp
                                <tr class="border-b border-slate-200 bg-white transition hover:bg-slate-50">
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-slate-900">{{ $reg->full_name }}</p>
                                        <p class="text-xs text-slate-500">{{ $reg->class }} - {{ $reg->major }}</p>
                                    </td>
                                    <td class="px-6 py-4">{{ $reg->nisn }}</td>
                                    <td class="px-6 py-4">
                                        <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-800 shadow-sm transition hover:border-emerald-400 hover:bg-emerald-600 hover:text-white">
                                            <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24">
                                                <path d="M12.04 2C6.59 2 2.18 6.38 2.18 11.81c0 2.05.61 4.04 1.66 5.76L2 22l4.6-1.53a9.8 9.8 0 0 0 5.44 1.73h.01c5.45 0 9.86-4.38 9.86-9.81S17.49 2 12.04 2Zm5.55 13.55c-.24.66-1.42 1.22-1.94 1.29-.5.07-1.13.09-3.68-.77-3.12-1.38-5.12-4.94-5.27-5.17-.15-.23-1.25-1.67-1.25-3.17 0-1.5.77-2.24 1.05-2.54.28-.3.6-.38.8-.38h.57c.18 0 .43.01.66.5.3.64.97 2.2.99 2.38.02.17-.14.41-.27.55-.16.15-.32.35-.46.48-.28.29-.58.63-.4 1.2.18.57 1.03 1.89 2.2 3.06 1.54 1.38 2.8 1.81 3.38 2.01.57.2.91.17 1.24-.1.45-.38 1.09-.95 1.39-1.28.3-.33.61-.28.98-.17.37.11 2.34 1.1 2.75 1.3.4.2.67.3.77.47.1.17.1.98-.13 1.64Z"/>
                                            </svg>
                                            {{ $reg->whatsapp_number }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">{{ $reg->preferred_division }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-bold {{ $status == 'pending' ? 'bg-yellow-100 text-yellow-700' : ($status == 'accepted' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex flex-wrap items-center justify-center gap-2">
                                            <a href="{{ route('admin.registrations.show', $reg->id) }}" class="inline-flex items-center rounded-md bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-700 transition hover:bg-slate-200">Lihat detail</a>
                                            <a href="{{ route('admin.registrations.edit', $reg->id) }}" class="inline-flex items-center rounded-md bg-amber-500 px-3 py-1.5 text-xs font-bold text-white transition hover:bg-amber-600">Edit</a>
                                            <form action="{{ route('admin.registrations.destroy', $reg->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data pendaftar ini?')" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-3 py-1.5 text-xs font-bold text-white transition hover:bg-red-700">Hapus</button>
                                            </form>

                                            @if($status === 'pending')
                                                <form action="{{ route('admin.registrations.update', $reg->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="accepted">
                                                    <button type="submit" class="rounded-md bg-emerald-600 px-3 py-1.5 text-xs font-bold text-white transition hover:bg-emerald-700">Terima</button>
                                                </form>
                                                <form action="{{ route('admin.registrations.update', $reg->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="rounded-md bg-red-600 px-3 py-1.5 text-xs font-bold text-white transition hover:bg-red-700">Tolak</button>
                                                </form>
                                            @else
                                                <span class="text-xs font-semibold text-slate-500">Sudah diproses</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-slate-500">Belum ada data pendaftaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-slate-200 bg-slate-50/50 px-6 py-4">
                    {{ $registrations->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>