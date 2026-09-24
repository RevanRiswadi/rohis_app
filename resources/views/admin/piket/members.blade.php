<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Anggota Piket</h2>
            <a href="{{ route('admin.piket.index') }}"
               class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2 px-4 rounded-lg text-sm transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali ke Absensi
            </a>
        </div>
    </x-slot>

    <div class="py-12 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        @if(session('success'))
            <div class="flex items-center gap-2 p-4 text-sm text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl font-bold">
                <i data-lucide="check-circle-2" class="w-4 h-4 shrink-0"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- FORM TAMBAH ANGGOTA BARU --}}
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-5">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i data-lucide="user-plus" class="h-5 w-5"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900">Tambah Anggota Baru</h3>
                    <p class="text-xs text-slate-500">Anggota baru akan muncul di absensi piket dan kajian.</p>
                </div>
            </div>

            <form action="{{ route('admin.piket.members.store') }}" method="POST"
                  class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                @csrf
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Contoh: Ahmad Fauzi"
                        class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Jenis Kelamin</label>
                    <select name="gender" required
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="Ikhwan">Ikhwan (Putra)</option>
                        <option value="Akhwat">Akhwat (Putri)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Jadwal Piket</label>
                    <select name="day" required
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="Senin">Senin</option>
                        <option value="Kamis">Kamis</option>
                    </select>
                </div>
                <div class="sm:col-span-4 flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-2.5 text-sm font-bold text-white shadow-md shadow-emerald-600/20 transition hover:bg-emerald-700">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Tambah Anggota
                    </button>
                </div>
            </form>
        </div>

        {{-- DAFTAR + EDIT JADWAL --}}
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-5">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <i data-lucide="settings-2" class="h-5 w-5"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900">Daftar Anggota & Jadwal Piket</h3>
                    <p class="text-xs text-slate-500">Klik Senin/Kamis untuk pindahkan jadwal, lalu simpan.</p>
                </div>
            </div>

            <form action="{{ route('admin.piket.updateMembers') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                    {{-- IKHWAN --}}
                    <div>
                        <h4 class="font-extrabold text-slate-800 border-b-2 border-emerald-100 pb-2 mb-3 flex items-center gap-2">
                            <i data-lucide="user" class="w-4 h-4 text-blue-500"></i>
                            Ikhwan
                            <span class="ml-auto text-xs font-semibold text-slate-400">{{ $ikhwan->count() }} orang</span>
                        </h4>
                        <div class="space-y-2">
                            @forelse($ikhwan as $member)
                                <div class="group flex items-center justify-between p-2.5 hover:bg-slate-50 rounded-xl border border-transparent hover:border-slate-200 transition">
                                    <span class="font-medium text-slate-800 text-sm">{{ $member->name }}</span>

                                    <div class="flex items-center gap-2">
                                        {{-- Toggle hari --}}
                                        <div class="flex p-1 gap-1 bg-slate-100 border border-slate-200 rounded-lg">
                                            <label class="cursor-pointer">
                                                <input type="radio" name="days[{{ $member->id }}]" value="Senin" class="peer sr-only" {{ $member->day == 'Senin' ? 'checked' : '' }}>
                                                <div class="px-3 py-1 text-xs font-bold text-slate-400 rounded-md transition peer-checked:bg-blue-600 peer-checked:text-white peer-checked:shadow hover:text-slate-700">Senin</div>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="days[{{ $member->id }}]" value="Kamis" class="peer sr-only" {{ $member->day == 'Kamis' ? 'checked' : '' }}>
                                                <div class="px-3 py-1 text-xs font-bold text-slate-400 rounded-md transition peer-checked:bg-orange-500 peer-checked:text-white peer-checked:shadow hover:text-slate-700">Kamis</div>
                                            </label>
                                        </div>

                                        {{-- Hapus --}}
                                        <form action="{{ route('admin.piket.members.destroy', $member) }}" method="POST"
                                              onsubmit="return confirm('Hapus {{ addslashes($member->name) }} dari daftar anggota piket? Data absensinya juga akan terhapus.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="opacity-0 group-hover:opacity-100 flex h-7 w-7 items-center justify-center rounded-lg text-slate-300 hover:bg-rose-50 hover:text-rose-500 transition">
                                                <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400 italic py-4 text-center">Belum ada anggota ikhwan.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- AKHWAT --}}
                    <div>
                        <h4 class="font-extrabold text-slate-800 border-b-2 border-emerald-100 pb-2 mb-3 flex items-center gap-2">
                            <i data-lucide="user" class="w-4 h-4 text-purple-500"></i>
                            Akhwat
                            <span class="ml-auto text-xs font-semibold text-slate-400">{{ $akhwat->count() }} orang</span>
                        </h4>
                        <div class="space-y-2">
                            @forelse($akhwat as $member)
                                <div class="group flex items-center justify-between p-2.5 hover:bg-slate-50 rounded-xl border border-transparent hover:border-slate-200 transition">
                                    <span class="font-medium text-slate-800 text-sm">{{ $member->name }}</span>

                                    <div class="flex items-center gap-2">
                                        <div class="flex p-1 gap-1 bg-slate-100 border border-slate-200 rounded-lg">
                                            <label class="cursor-pointer">
                                                <input type="radio" name="days[{{ $member->id }}]" value="Senin" class="peer sr-only" {{ $member->day == 'Senin' ? 'checked' : '' }}>
                                                <div class="px-3 py-1 text-xs font-bold text-slate-400 rounded-md transition peer-checked:bg-blue-600 peer-checked:text-white peer-checked:shadow hover:text-slate-700">Senin</div>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="days[{{ $member->id }}]" value="Kamis" class="peer sr-only" {{ $member->day == 'Kamis' ? 'checked' : '' }}>
                                                <div class="px-3 py-1 text-xs font-bold text-slate-400 rounded-md transition peer-checked:bg-orange-500 peer-checked:text-white peer-checked:shadow hover:text-slate-700">Kamis</div>
                                            </label>
                                        </div>

                                        <form action="{{ route('admin.piket.members.destroy', $member) }}" method="POST"
                                              onsubmit="return confirm('Hapus {{ addslashes($member->name) }} dari daftar anggota piket?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="opacity-0 group-hover:opacity-100 flex h-7 w-7 items-center justify-center rounded-lg text-slate-300 hover:bg-rose-50 hover:text-rose-500 transition">
                                                <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400 italic py-4 text-center">Belum ada anggota akhwat.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="mt-8 border-t border-slate-100 pt-5 flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-emerald-600/20 transition hover:-translate-y-0.5">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Simpan Perubahan Jadwal
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
