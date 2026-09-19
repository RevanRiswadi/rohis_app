<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-emerald-700">Anggota</p>
                <h2 class="text-2xl font-extrabold leading-tight text-slate-900">
                    {{ __('Daftar Anggota Resmi') }}
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

            <div class="overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white shadow-[0_20px_45px_rgba(15,23,42,0.06)]">
                <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 via-white to-emerald-50 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-lg font-black text-slate-900">Daftar Anggota Resmi</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-[0.12em] text-slate-600">
                            <tr>
                                <th class="px-6 py-3">NISN</th>
                                <th class="px-6 py-3">Nama</th>
                                <th class="px-6 py-3">Kelas / Jurusan</th>
                                <th class="px-6 py-3">No WhatsApp</th>
                                <th class="px-6 py-3">Divisi</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $member)
                                <tr class="border-b border-slate-200 bg-white transition hover:bg-slate-50">
                                    <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $member->nisn }}</td>
                                    <td class="px-6 py-4 font-bold text-slate-900">{{ $member->name }}</td>
                                    <td class="px-6 py-4">{{ $member->class }} - {{ $member->major }}</td>
                                    <td class="px-6 py-4">{{ $member->whatsapp_number }}</td>
                                    <td class="px-6 py-4">{{ $member->division }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($member->is_active)
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-bold text-emerald-700">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-bold text-slate-700">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex flex-wrap items-center justify-center gap-2">
                                            <form action="{{ route('admin.members.update', $member->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="is_active" value="{{ $member->is_active ? 0 : 1 }}">
                                                <button type="submit" class="rounded-md {{ $member->is_active ? 'bg-amber-500 hover:bg-amber-600' : 'bg-emerald-600 hover:bg-emerald-700' }} px-3 py-1.5 text-xs font-bold text-white transition">
                                                    {{ $member->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-md bg-red-600 px-3 py-1.5 text-xs font-bold text-white transition hover:bg-red-700">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-slate-500">Belum ada anggota resmi. Terima pendaftaran terlebih dahulu.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($members->hasPages())
                    <div class="border-t border-slate-200 p-4">
                        {{ $members->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
