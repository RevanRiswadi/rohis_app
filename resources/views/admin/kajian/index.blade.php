<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-extrabold leading-tight text-gray-900">Absensi Kajian</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
                    <i data-lucide="check-circle-2" class="h-5 w-5 shrink-0"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                {{-- ===== SIDEBAR KIRI ===== --}}
                <div class="space-y-4 self-start">

                    {{-- Panel Daftar Kajian --}}
                    <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm space-y-3">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                    <i data-lucide="calendar-check" class="h-5 w-5"></i>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-slate-900 text-sm">Daftar Kajian</h3>
                                    <p class="text-[11px] text-slate-400">Klik untuk isi absensi</p>
                                </div>
                            </div>
                            <button onclick="toggleTambahForm()"
                                class="inline-flex items-center gap-1 rounded-xl bg-emerald-600 px-3 py-1.5 text-xs font-bold text-white transition hover:bg-emerald-700">
                                <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                                Tambah
                            </button>
                        </div>

                        {{-- Form Tambah Kajian (toggle) --}}
                        <div id="formTambahKajian" class="hidden">
                            <form action="{{ route('admin.schedules.store') }}" method="POST" class="space-y-3 pb-3 border-b border-slate-100">
                                @csrf
                                <input type="hidden" name="_redirect" value="{{ url()->current() }}">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">Judul Kajian</label>
                                    <input type="text" name="title" required placeholder="Contoh: Kajian Akbar Pekan 1"
                                        class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1">Tanggal</label>
                                        <input type="datetime-local" name="event_date" required
                                            class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs focus:border-emerald-500 focus:ring-emerald-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1">Lokasi</label>
                                        <input type="text" name="location" required placeholder="Masjid..."
                                            class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">Pembicara <span class="font-normal text-slate-400">(opsional)</span></label>
                                    <input type="text" name="speaker" placeholder="Nama ustadz..."
                                        class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">Deskripsi</label>
                                    <textarea name="description" rows="2" required placeholder="Tema / materi kajian..."
                                        class="w-full resize-none rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500"></textarea>
                                </div>
                                <input type="hidden" name="status" value="upcoming">
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 py-2.5 text-sm font-bold text-white transition hover:bg-emerald-700">
                                    <i data-lucide="save" class="h-4 w-4"></i>
                                    Simpan Kajian Baru
                                </button>
                            </form>
                        </div>

                        {{-- List jadwal --}}
                        @if($schedules->isEmpty())
                            <div class="py-6 text-center">
                                <i data-lucide="calendar-x" class="h-8 w-8 mx-auto text-slate-300 mb-2"></i>
                                <p class="text-sm text-slate-400 italic">Belum ada jadwal kajian.</p>
                                <p class="text-xs text-slate-400 mt-1">Klik tombol <strong>Tambah</strong> di atas.</p>
                            </div>
                        @else
                            <div class="space-y-1 max-h-[60vh] overflow-y-auto pr-1">
                                @foreach($schedules as $schedule)
                                    @php
                                        $isSelected = optional($selectedSchedule)->id === $schedule->id;
                                        $hadirCount = \App\Models\KajianAttendance::where('schedule_id', $schedule->id)->where('hadir', true)->count();
                                        $totalMember = \App\Models\PiketMember::count();
                                    @endphp
                                    <div class="group flex items-center gap-1">
                                        <a href="{{ route('admin.kajian.index', ['schedule_id' => $schedule->id]) }}"
                                           class="flex flex-1 items-center justify-between rounded-xl px-3 py-2.5 transition min-w-0
                                               {{ $isSelected ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:bg-slate-50' }}">
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold truncate">{{ $schedule->title }}</p>
                                                <p class="text-[11px] mt-0.5 {{ $isSelected ? 'text-emerald-100' : 'text-slate-400' }}">
                                                    {{ $schedule->event_date->translatedFormat('d M Y') }}
                                                </p>
                                            </div>
                                            @if($hadirCount > 0)
                                                <span class="ml-2 shrink-0 text-[11px] font-bold px-2 py-0.5 rounded-full {{ $isSelected ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-700' }}">
                                                    {{ $hadirCount }}/{{ $totalMember }}
                                                </span>
                                            @endif
                                        </a>

                                        {{-- Edit + Hapus --}}
                                        <div class="flex shrink-0 gap-0.5 opacity-0 group-hover:opacity-100 transition">
                                            <a href="{{ route('admin.schedules.edit', $schedule) }}"
                                               class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-amber-50 hover:text-amber-600 transition">
                                                <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                                            </a>
                                            <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST"
                                                  onsubmit="return confirm('Hapus kajian {{ addslashes($schedule->title) }}? Data absensi juga akan terhapus.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition">
                                                    <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>

                {{-- ===== PANEL ABSENSI ===== --}}
                <div class="lg:col-span-2 space-y-4">
                    @if(!$selectedSchedule)
                        <div class="flex flex-col items-center gap-3 rounded-[1.75rem] border border-slate-200 bg-white py-20 text-slate-400 shadow-sm">
                            <i data-lucide="calendar" class="h-10 w-10"></i>
                            <p class="text-sm font-medium">Pilih kajian dari daftar kiri untuk mulai absensi.</p>
                            <p class="text-xs text-slate-400">Atau tambah jadwal kajian baru dengan tombol <strong>Tambah</strong>.</p>
                        </div>
                    @else
                        <div class="rounded-[1.75rem] border border-slate-200 bg-white shadow-sm overflow-hidden">
                            {{-- Header --}}
                            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/60 flex items-start justify-between gap-4 flex-wrap">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">
                                        {{ $selectedSchedule->event_date->translatedFormat('l, d F Y') }}
                                    </p>
                                    <h3 class="text-xl font-extrabold text-slate-900 mt-0.5">{{ $selectedSchedule->title }}</h3>
                                    <div class="flex flex-wrap items-center gap-3 mt-1.5">
                                        @if($selectedSchedule->location)
                                            <p class="text-sm text-slate-500 flex items-center gap-1">
                                                <i data-lucide="map-pin" class="h-3.5 w-3.5"></i>
                                                {{ $selectedSchedule->location }}
                                            </p>
                                        @endif
                                        @if($selectedSchedule->speaker)
                                            <p class="text-sm text-slate-500 flex items-center gap-1">
                                                <i data-lucide="mic" class="h-3.5 w-3.5"></i>
                                                {{ $selectedSchedule->speaker }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="text-right">
                                        <p class="text-2xl font-black text-emerald-600">{{ $hadirCount }}/{{ $members->count() }}</p>
                                        <p class="text-xs font-semibold text-slate-500">hadir</p>
                                    </div>
                                    <a href="{{ route('admin.schedules.edit', $selectedSchedule) }}"
                                       class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 text-slate-400 transition hover:border-amber-200 hover:bg-amber-50 hover:text-amber-600">
                                        <i data-lucide="pencil" class="h-4 w-4"></i>
                                    </a>
                                </div>
                            </div>

                            {{-- Info kas --}}
                            <div class="px-6 py-3 bg-emerald-50/60 border-b border-emerald-100 flex items-center gap-2 text-xs font-semibold text-emerald-700">
                                <i data-lucide="wallet" class="h-3.5 w-3.5 shrink-0"></i>
                                Anggota yang ditandai <strong>Hadir</strong> otomatis tercatat lunas iuran kas tanggal {{ $selectedSchedule->event_date->format('d/m/Y') }}.
                            </div>

                            <form action="{{ route('admin.kajian.store') }}" method="POST" class="p-6">
                                @csrf
                                <input type="hidden" name="schedule_id" value="{{ $selectedSchedule->id }}">

                                <div class="flex items-center justify-between mb-5 flex-wrap gap-2">
                                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Daftar Anggota</p>
                                    <div class="flex gap-2">
                                        <button type="button" onclick="toggleSemuaKajian(true)"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-emerald-300 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700 transition hover:bg-emerald-100">
                                            <i data-lucide="check-square" class="h-3.5 w-3.5"></i>
                                            Semua Hadir
                                        </button>
                                        <button type="button" onclick="toggleSemuaKajian(false)"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-bold text-slate-600 transition hover:bg-slate-100">
                                            <i data-lucide="square" class="h-3.5 w-3.5"></i>
                                            Kosongkan
                                        </button>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div>
                                        <h4 class="mb-3 flex items-center gap-2 border-b border-slate-100 pb-3 text-sm font-extrabold uppercase tracking-wider text-slate-700">
                                            <i data-lucide="user" class="h-4 w-4 text-blue-500"></i> Ikhwan
                                        </h4>
                                        <div class="space-y-1">
                                            @foreach($members->where('gender', 'Ikhwan') as $member)
                                                @php $hadir = $hadirMap->get($member->id, false); @endphp
                                                <label class="flex cursor-pointer items-center justify-between rounded-xl border px-4 py-3 transition
                                                    {{ $hadir ? 'border-emerald-200 bg-emerald-50' : 'border-transparent hover:bg-slate-50' }}">
                                                    <div class="flex items-center gap-3">
                                                        <input type="checkbox" name="hadir[]" value="{{ $member->id }}"
                                                            class="h-5 w-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                                                            {{ $hadir ? 'checked' : '' }}>
                                                        <span class="text-sm font-semibold text-slate-800">{{ $member->name }}</span>
                                                    </div>
                                                    @if($hadir)
                                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-[11px] font-extrabold text-emerald-700">
                                                            <i data-lucide="check" class="h-3 w-3"></i> Hadir
                                                        </span>
                                                    @else
                                                        <span class="text-[11px] font-bold text-slate-400">Absen</span>
                                                    @endif
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="mb-3 flex items-center gap-2 border-b border-slate-100 pb-3 text-sm font-extrabold uppercase tracking-wider text-slate-700">
                                            <i data-lucide="user" class="h-4 w-4 text-purple-500"></i> Akhwat
                                        </h4>
                                        <div class="space-y-1">
                                            @foreach($members->where('gender', 'Akhwat') as $member)
                                                @php $hadir = $hadirMap->get($member->id, false); @endphp
                                                <label class="flex cursor-pointer items-center justify-between rounded-xl border px-4 py-3 transition
                                                    {{ $hadir ? 'border-emerald-200 bg-emerald-50' : 'border-transparent hover:bg-slate-50' }}">
                                                    <div class="flex items-center gap-3">
                                                        <input type="checkbox" name="hadir[]" value="{{ $member->id }}"
                                                            class="h-5 w-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                                                            {{ $hadir ? 'checked' : '' }}>
                                                        <span class="text-sm font-semibold text-slate-800">{{ $member->name }}</span>
                                                    </div>
                                                    @if($hadir)
                                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-[11px] font-extrabold text-emerald-700">
                                                            <i data-lucide="check" class="h-3 w-3"></i> Hadir
                                                        </span>
                                                    @else
                                                        <span class="text-[11px] font-bold text-slate-400">Absen</span>
                                                    @endif
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 flex items-center justify-between border-t border-slate-100 pt-5 flex-wrap gap-3">
                                    <form action="{{ route('admin.kajian.destroy') }}" method="POST"
                                          onsubmit="return confirm('Reset absensi kajian ini? Data kas tidak akan berubah.')">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="schedule_id" value="{{ $selectedSchedule->id }}">
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-bold text-slate-500 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600">
                                            <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
                                            Reset Absensi
                                        </button>
                                    </form>

                                    <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-7 py-3 text-sm font-bold text-white shadow-md shadow-emerald-600/20 transition hover:bg-emerald-700">
                                        <i data-lucide="save" class="h-4 w-4"></i>
                                        Simpan Absensi
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSemuaKajian(status) {
            document.querySelectorAll('input[name="hadir[]"]').forEach(cb => {
                cb.checked = status;
                const label = cb.closest('label');
                if (label) {
                    label.classList.toggle('border-emerald-200', status);
                    label.classList.toggle('bg-emerald-50', status);
                    label.classList.toggle('border-transparent', !status);
                }
            });
        }

        function toggleTambahForm() {
            const form = document.getElementById('formTambahKajian');
            form.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
