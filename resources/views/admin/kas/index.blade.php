<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-extrabold leading-tight text-gray-900">Kas & Infaq</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            {{-- SALDO RINGKASAN --}}
            <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
                <div class="rounded-[1.75rem] bg-gradient-to-br from-emerald-500 to-teal-600 p-6 text-white shadow-lg shadow-emerald-500/20">
                    <div class="mb-3 flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/20">
                            <i data-lucide="trending-up" class="h-5 w-5"></i>
                        </div>
                        <p class="text-sm font-semibold text-emerald-100">Total Iuran Masuk</p>
                    </div>
                    <h3 class="text-3xl font-black">Rp {{ number_format($totalIuranMasuk, 0, ',', '.') }}</h3>
                </div>

                <div class="rounded-[1.75rem] p-6 text-white shadow-lg" style="background: linear-gradient(135deg, #f43f5e, #ec4899);">
                    <div class="mb-3 flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/20">
                            <i data-lucide="trending-down" class="h-5 w-5"></i>
                        </div>
                        <p class="text-sm font-semibold" style="color:#fecdd3;">Total Pengeluaran</p>
                    </div>
                    <h3 class="text-3xl font-black">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
                </div>

                <div class="rounded-[1.75rem] p-6 text-white shadow-lg" style="background: linear-gradient(135deg, #1e293b, #0f172a);">
                    <div class="mb-3 flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/10">
                            <i data-lucide="wallet" class="h-5 w-5"></i>
                        </div>
                        <p class="text-sm font-semibold" style="color:#cbd5e1;">Sisa Saldo Kas</p>
                    </div>
                    <h3 class="text-4xl font-black {{ $saldoAkhir >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                        Rp {{ number_format($saldoAkhir, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            {{-- FLASH MESSAGE --}}
            @if(session('success'))
                <div class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
                    <i data-lucide="check-circle-2" class="h-5 w-5 shrink-0"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- TAB NAVIGATION --}}
            <div class="flex gap-2 rounded-2xl border border-slate-200 bg-white p-1.5 shadow-sm w-fit">
                <a href="{{ route('admin.kas.index', ['tab' => 'iuran', 'tanggal' => $tanggalPertemuan]) }}"
                    class="inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold transition {{ $tab === 'iuran' ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800' }}">
                    <i data-lucide="check-square" class="h-4 w-4"></i>
                    Iuran Mingguan
                </a>
                <a href="{{ route('admin.kas.index', ['tab' => 'rekap', 'tahun' => $tahunDipilih, 'bulan' => $bulanDipilih]) }}"
                    class="inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold transition {{ $tab === 'rekap' ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800' }}">
                    <i data-lucide="bar-chart-2" class="h-4 w-4"></i>
                    Rekap
                </a>
                <a href="{{ route('admin.kas.index', ['tab' => 'pengeluaran']) }}"
                    class="inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold transition {{ $tab === 'pengeluaran' ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800' }}">
                    <i data-lucide="receipt" class="h-4 w-4"></i>
                    Pengeluaran & Struk
                </a>
            </div>

            {{-- ===== TAB 1: IURAN MINGGUAN ===== --}}
            @if($tab === 'iuran')
                @php
                    $statusDipilihVal = optional($statusDipilih)->status_pertemuan;
                    $isLibur = $statusDipilihVal === 'libur';
                    $sudahBayarCount = $iuranHariIni->filter(fn($v) => $v)->count();
                    $totalAnggota = $members->count();
                @endphp
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                    {{-- SIDEBAR: Daftar Sabtu otomatis --}}
                    <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm self-start space-y-3">
                        <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                <i data-lucide="calendar" class="h-5 w-5"></i>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-slate-900 text-sm">Pertemuan Sabtu</h3>
                                <p class="text-[11px] text-slate-400">Iuran Rp 2.000/pertemuan</p>
                            </div>
                        </div>

                        {{-- Legenda --}}
                        <div class="flex flex-wrap gap-2 pb-2">
                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-bold text-emerald-700">
                                <i data-lucide="check-circle-2" class="h-3 w-3"></i> Sudah direkap
                            </span>
                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-1 text-[10px] font-bold text-amber-700">
                                <i data-lucide="moon" class="h-3 w-3"></i> Libur
                            </span>
                            <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold text-slate-500">
                                <i data-lucide="clock" class="h-3 w-3"></i> Belum diisi
                            </span>
                        </div>

                        <div class="space-y-1 max-h-[70vh] overflow-y-auto pr-1">
                            @foreach($daftarSabtu as $sabtu)
                                @php
                                    $tglStr = $sabtu->toDateString();
                                    $dataSabtu = $statusPertemuan->get($tglStr);
                                    $statusSabtu = optional($dataSabtu)->status_pertemuan; // 'rekap', 'libur', null
                                    $isActive = $tglStr === $tanggalPertemuan;
                                    $isFuture = $sabtu->isFuture() && !$sabtu->isToday();
                                @endphp
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('admin.kas.index', ['tab' => 'iuran', 'tanggal' => $tglStr]) }}"
                                        class="flex flex-1 items-center justify-between rounded-xl px-3 py-2.5 text-sm font-semibold transition
                                            {{ $isActive ? 'bg-emerald-600 text-white' : ($isFuture ? 'text-slate-400 hover:bg-slate-50' : 'text-slate-700 hover:bg-slate-50') }}">
                                        <div class="flex items-center gap-2">
                                            {{-- Badge status --}}
                                            @if($statusSabtu === 'rekap')
                                                <span class="h-2 w-2 rounded-full {{ $isActive ? 'bg-white' : 'bg-emerald-500' }}"></span>
                                            @elseif($statusSabtu === 'libur')
                                                <span class="h-2 w-2 rounded-full {{ $isActive ? 'bg-white' : 'bg-amber-400' }}"></span>
                                            @else
                                                <span class="h-2 w-2 rounded-full {{ $isActive ? 'bg-white/60' : 'bg-slate-300' }}"></span>
                                            @endif
                                            <span>{{ $sabtu->translatedFormat('d M Y') }}</span>
                                        </div>
                                        @if($statusSabtu === 'libur' && !$isActive)
                                            <span class="text-[10px] font-bold text-amber-500">Libur</span>
                                        @elseif($statusSabtu === 'rekap' && !$isActive)
                                            <span class="text-[10px] font-bold text-emerald-600">Rekap</span>
                                        @elseif($isActive)
                                            <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
                                        @endif
                                    </a>

                                    {{-- Hapus hanya jika sudah ada data --}}
                                    @if($statusSabtu)
                                        <form action="{{ route('admin.kas.iuran.destroy') }}" method="POST"
                                            onsubmit="return confirm('Reset data pertemuan {{ $sabtu->translatedFormat('d M Y') }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="tanggal_pertemuan" value="{{ $tglStr }}">
                                            <button type="submit"
                                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-slate-300 transition hover:bg-rose-50 hover:text-rose-500">
                                                <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- PANEL UTAMA --}}
                    <div class="lg:col-span-2 space-y-4">

                        {{-- Panel Libur --}}
                        @if($isLibur)
                            <div class="rounded-[1.75rem] border-2 border-amber-200 bg-amber-50 p-6">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-100 text-amber-600">
                                        <i data-lucide="moon" class="h-6 w-6"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-extrabold text-amber-900">Pertemuan Ini Libur</h3>
                                        <p class="text-sm text-amber-700">{{ \Carbon\Carbon::parse($tanggalPertemuan)->translatedFormat('l, d F Y') }}</p>
                                    </div>
                                </div>
                                @if(optional($statusDipilih)->keterangan_libur)
                                    <p class="mt-1 text-sm text-amber-800 bg-amber-100 rounded-xl px-4 py-2.5 border border-amber-200">
                                        {{ $statusDipilih->keterangan_libur }}
                                    </p>
                                @endif
                                <p class="mt-4 text-xs text-amber-600">Ingin membatalkan status libur? Hapus pertemuan ini lewat tombol di sidebar lalu isi ulang.</p>
                            </div>
                        @endif

                        {{-- Tombol tandai libur (tampil kalau belum diisi atau sudah rekap) --}}
                        @if(!$isLibur)
                            <div class="rounded-[1.75rem] border border-slate-200 bg-white shadow-sm overflow-hidden">
                                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between flex-wrap gap-3">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">
                                                Sabtu, {{ \Carbon\Carbon::parse($tanggalPertemuan)->translatedFormat('d F Y') }}
                                            </p>
                                            @if($iuranHariIni->isNotEmpty())
                                                <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-0.5 text-[11px] font-extrabold text-amber-700">
                                                    <i data-lucide="pencil" class="h-3 w-3"></i> Mode Edit
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xl font-extrabold text-slate-900 mt-0.5">
                                            Iuran Rp 2.000/pertemuan
                                        </p>
                                        @if($iuranHariIni->isNotEmpty())
                                            <p class="mt-0.5 text-xs text-slate-500">Data tersimpan — ubah centang lalu simpan ulang.</p>
                                        @endif
                                    </div>
                                    <div class="flex flex-col items-end gap-2">
                                        <div class="text-right">
                                            <p class="text-2xl font-black text-emerald-600">{{ $sudahBayarCount }}/{{ $totalAnggota }}</p>
                                            <p class="text-xs font-semibold text-slate-500">sudah bayar</p>
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="button" onclick="toggleSemuaIuran(true)"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-emerald-300 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700 transition hover:bg-emerald-100">
                                                <i data-lucide="check-square" class="h-3.5 w-3.5"></i>
                                                Ceklis Semua
                                            </button>
                                            <button type="button" onclick="toggleSemuaIuran(false)"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-bold text-slate-600 transition hover:bg-slate-100">
                                                <i data-lucide="square" class="h-3.5 w-3.5"></i>
                                                Kosongkan
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('admin.kas.iuran.store') }}" method="POST" class="p-6">
                                    @csrf
                                    <input type="hidden" name="tanggal_pertemuan" value="{{ $tanggalPertemuan }}">
                                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                        {{-- Ikhwan --}}
                                        <div>
                                            <h4 class="mb-3 flex items-center gap-2 border-b border-slate-100 pb-3 text-sm font-extrabold uppercase tracking-wider text-slate-700">
                                                <i data-lucide="user" class="h-4 w-4 text-blue-500"></i> Ikhwan
                                            </h4>
                                            <div class="space-y-1">
                                                @foreach($members->where('gender', 'Ikhwan') as $member)
                                                    @php $sudah = $iuranHariIni->get($member->id, false); @endphp
                                                    <label class="flex cursor-pointer items-center justify-between rounded-xl border px-4 py-3 transition {{ $sudah ? 'border-emerald-200 bg-emerald-50' : 'border-transparent hover:bg-slate-50' }}">
                                                        <div class="flex items-center gap-3">
                                                            <input type="checkbox" name="sudah_bayar[]" value="{{ $member->id }}"
                                                                class="h-5 w-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                                                                {{ $sudah ? 'checked' : '' }}>
                                                            <span class="text-sm font-semibold text-slate-800">{{ $member->name }}</span>
                                                        </div>
                                                        @if($sudah)
                                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-[11px] font-extrabold text-emerald-700">
                                                                <i data-lucide="check" class="h-3 w-3"></i> Lunas
                                                            </span>
                                                        @else
                                                            <span class="text-[11px] font-bold text-slate-400">Belum</span>
                                                        @endif
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        {{-- Akhwat --}}
                                        <div>
                                            <h4 class="mb-3 flex items-center gap-2 border-b border-slate-100 pb-3 text-sm font-extrabold uppercase tracking-wider text-slate-700">
                                                <i data-lucide="user" class="h-4 w-4 text-purple-500"></i> Akhwat
                                            </h4>
                                            <div class="space-y-1">
                                                @foreach($members->where('gender', 'Akhwat') as $member)
                                                    @php $sudah = $iuranHariIni->get($member->id, false); @endphp
                                                    <label class="flex cursor-pointer items-center justify-between rounded-xl border px-4 py-3 transition {{ $sudah ? 'border-emerald-200 bg-emerald-50' : 'border-transparent hover:bg-slate-50' }}">
                                                        <div class="flex items-center gap-3">
                                                            <input type="checkbox" name="sudah_bayar[]" value="{{ $member->id }}"
                                                                class="h-5 w-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                                                                {{ $sudah ? 'checked' : '' }}>
                                                            <span class="text-sm font-semibold text-slate-800">{{ $member->name }}</span>
                                                        </div>
                                                        @if($sudah)
                                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-[11px] font-extrabold text-emerald-700">
                                                                <i data-lucide="check" class="h-3 w-3"></i> Lunas
                                                            </span>
                                                        @else
                                                            <span class="text-[11px] font-bold text-slate-400">Belum</span>
                                                        @endif
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-6 flex items-center justify-between border-t border-slate-100 pt-5">
                                        <p class="text-xs text-slate-500">Centang = sudah bayar iuran Rp 2.000</p>
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-7 py-3 text-sm font-bold text-white shadow-md shadow-emerald-600/20 transition hover:bg-emerald-700">
                                            <i data-lucide="save" class="h-4 w-4"></i>
                                            Simpan Iuran
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        {{-- Form tandai libur (selalu tampil di bawah, bisa dipakai untuk override) --}}
                        <div class="rounded-[1.75rem] border border-amber-200 bg-white shadow-sm overflow-hidden">
                            <button type="button" onclick="toggleFormLibur()"
                                class="w-full flex items-center justify-between px-6 py-4 text-left hover:bg-amber-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-50 text-amber-500">
                                        <i data-lucide="moon" class="h-5 w-5"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">Tandai sebagai Libur</p>
                                        <p class="text-xs text-slate-500">Pertemuan minggu ini diliburkan?</p>
                                    </div>
                                </div>
                                <i data-lucide="chevron-down" class="h-4 w-4 text-slate-400 transition-transform" id="iconChevronLibur"></i>
                            </button>

                            <div id="formLiburPanel" class="hidden border-t border-amber-100 px-6 py-5">
                                <form action="{{ route('admin.kas.iuran.libur') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="tanggal_pertemuan" value="{{ $tanggalPertemuan }}">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                            Alasan / Keterangan
                                            <span class="font-normal text-slate-400">(opsional)</span>
                                        </label>
                                        <input type="text" name="keterangan_libur"
                                            placeholder="Contoh: Libur Hari Raya, Ujian Sekolah..."
                                            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-amber-400">
                                    </div>
                                    <button type="submit"
                                        onclick="return confirm('Tandai pertemuan {{ \Carbon\Carbon::parse($tanggalPertemuan)->translatedFormat('d M Y') }} sebagai libur? Data iuran yang sudah ada akan dihapus.')"
                                        class="inline-flex items-center gap-2 rounded-xl bg-amber-500 px-6 py-2.5 text-sm font-bold text-white transition hover:bg-amber-600">
                                        <i data-lucide="moon" class="h-4 w-4"></i>
                                        Konfirmasi Libur
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            @endif

            {{-- ===== TAB 2: REKAP ===== --}}
            @if($tab === 'rekap')
                <form action="{{ route('admin.kas.index') }}" method="GET"
                    class="flex flex-wrap items-end gap-4 rounded-2xl border border-slate-200 bg-white px-6 py-5 shadow-sm">
                    <input type="hidden" name="tab" value="rekap">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Bulan</label>
                        <select name="bulan" class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            @foreach(range(1,12) as $m)
                                <option value="{{ $m }}" {{ $bulanDipilih == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Tahun</label>
                        <select name="tahun" class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            @foreach($tahunTersedia->merge([now()->year])->unique()->sort()->values() as $t)
                                <option value="{{ $t }}" {{ $tahunDipilih == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="rounded-xl bg-slate-800 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-slate-900">
                        Tampilkan
                    </button>
                </form>

                {{-- Rekap Bulanan --}}
                <div class="rounded-[1.75rem] border border-slate-200 bg-white shadow-sm overflow-hidden">
                    <div class="border-b border-slate-100 bg-slate-50/60 px-6 py-5">
                        <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Rekap Bulanan</p>
                        <h3 class="mt-0.5 text-xl font-extrabold text-slate-900">
                            {{ \Carbon\Carbon::create()->month($bulanDipilih)->translatedFormat('F') }} {{ $tahunDipilih }}
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        @if($pertemuanBulanIni->isEmpty())
                            <div class="flex flex-col items-center gap-3 py-14 text-slate-400">
                                <i data-lucide="calendar-x" class="h-10 w-10"></i>
                                <p class="text-sm font-medium">Belum ada data iuran bulan ini.</p>
                            </div>
                        @else
                            <table class="w-full text-sm">
                                <thead class="border-b border-slate-100 bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">
                                    <tr>
                                        <th class="sticky left-0 bg-slate-50 px-5 py-3 text-left">Anggota</th>
                                        @foreach($pertemuanBulanIni as $tgl)
                                            <th class="whitespace-nowrap px-3 py-3 text-center">
                                                Sabtu<br>{{ \Carbon\Carbon::parse($tgl)->format('d/m') }}
                                            </th>
                                        @endforeach
                                        <th class="px-5 py-3 text-center">Lunas</th>
                                        <th class="px-5 py-3 text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($members as $member)
                                        @php
                                            $iuranMember = $rekapBulanan->get($member->id, collect());
                                            $iuranByTgl = $iuranMember->keyBy(fn($i) => $i->tanggal_pertemuan->toDateString());
                                            $totalBayar = $iuranMember->where('sudah_bayar', true)->sum('nominal');
                                            $lunasCount = $iuranMember->where('sudah_bayar', true)->count();
                                        @endphp
                                        <tr class="transition hover:bg-slate-50/60">
                                            <td class="sticky left-0 bg-white px-5 py-3 font-semibold text-slate-800">
                                                <div class="flex items-center gap-2">
                                                    <span class="h-2 w-2 rounded-full {{ $member->gender === 'Ikhwan' ? 'bg-blue-400' : 'bg-purple-400' }}"></span>
                                                    {{ $member->name }}
                                                </div>
                                            </td>
                                            @foreach($pertemuanBulanIni as $tgl)
                                                @php $rec = $iuranByTgl->get($tgl->toDateString()); @endphp
                                                <td class="px-3 py-3 text-center">
                                                    @if($rec && $rec->sudah_bayar)
                                                        <i data-lucide="check-circle-2" class="mx-auto h-4 w-4 text-emerald-500"></i>
                                                    @elseif($rec)
                                                        <i data-lucide="circle" class="mx-auto h-4 w-4 text-slate-300"></i>
                                                    @else
                                                        <span class="text-slate-200">—</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td class="px-5 py-3 text-center font-bold {{ $lunasCount === $pertemuanBulanIni->count() && $lunasCount > 0 ? 'text-emerald-600' : 'text-slate-500' }}">
                                                {{ $lunasCount }}/{{ $pertemuanBulanIni->count() }}
                                            </td>
                                            <td class="px-5 py-3 text-right font-bold text-emerald-600">
                                                Rp {{ number_format($totalBayar, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>

                {{-- Rekap Tahunan --}}
                <div class="rounded-[1.75rem] border border-slate-200 bg-white shadow-sm overflow-hidden">
                    <div class="border-b border-slate-100 bg-slate-50/60 px-6 py-5">
                        <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Rekap Tahunan</p>
                        <h3 class="mt-0.5 text-xl font-extrabold text-slate-900">Total Iuran Tahun {{ $tahunDipilih }}</h3>
                    </div>
                    <div class="overflow-x-auto">
                        @if($rekapTahunan->isEmpty())
                            <div class="flex flex-col items-center gap-3 py-14 text-slate-400">
                                <i data-lucide="calendar-x" class="h-10 w-10"></i>
                                <p class="text-sm font-medium">Belum ada data iuran tahun {{ $tahunDipilih }}.</p>
                            </div>
                        @else
                            <table class="w-full text-sm">
                                <thead class="border-b border-slate-100 bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">
                                    <tr>
                                        <th class="px-5 py-3 text-left">Anggota</th>
                                        <th class="px-5 py-3 text-center">Jenis</th>
                                        <th class="px-5 py-3 text-center">Hadir Bayar</th>
                                        <th class="px-5 py-3 text-right">Total Iuran</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($members as $member)
                                        @php $rekap = $rekapTahunan->firstWhere('piket_member_id', $member->id); @endphp
                                        <tr class="transition hover:bg-slate-50/60">
                                            <td class="px-5 py-3 font-semibold text-slate-800">
                                                <div class="flex items-center gap-2">
                                                    <span class="h-2 w-2 rounded-full {{ $member->gender === 'Ikhwan' ? 'bg-blue-400' : 'bg-purple-400' }}"></span>
                                                    {{ $member->name }}
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 text-center text-slate-500">{{ $member->gender }}</td>
                                            <td class="px-5 py-3 text-center font-bold text-slate-700">{{ $rekap ? $rekap->hadir_bayar : 0 }}x</td>
                                            <td class="px-5 py-3 text-right font-bold text-emerald-600">
                                                Rp {{ number_format($rekap ? $rekap->total_bayar : 0, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            @endif

            {{-- ===== TAB 3: PENGELUARAN & STRUK ===== --}}
            @if($tab === 'pengeluaran')
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm self-start">
                        <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-rose-500">
                            <i data-lucide="receipt" class="h-6 w-6"></i>
                        </div>
                        <h3 class="mb-5 text-xl font-extrabold text-slate-900">Catat Pengeluaran</h3>
                        <form action="{{ route('admin.kas.pengeluaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-slate-700">Tanggal</label>
                                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-slate-700">Keperluan</label>
                                <input type="text" name="keperluan" required placeholder="Contoh: Beli sapu masjid"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-slate-700">Nominal (Rp)</label>
                                <input type="number" name="nominal" required placeholder="Contoh: 25000" min="1"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-slate-700">Catatan Detail</label>
                                <textarea name="catatan" rows="3" placeholder="Detail barang, harga satuan, dll..."
                                    class="w-full resize-none rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500"></textarea>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                                    Foto Struk <span class="font-normal text-slate-400">(opsional)</span>
                                </label>
                                <input type="file" name="foto_struk" accept="image/*"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-emerald-700 hover:file:bg-emerald-100">
                                <p class="mt-1 text-xs text-slate-400">Max 3MB. JPG/PNG/WEBP.</p>
                            </div>
                            <button type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl py-3 text-sm font-bold text-white shadow-md transition hover:opacity-90"
                                style="background: linear-gradient(135deg, #f43f5e, #ec4899);">
                                <i data-lucide="save" class="h-4 w-4"></i>
                                Simpan Pengeluaran
                            </button>
                        </form>
                    </div>

                    <div class="lg:col-span-2 rounded-[1.75rem] border border-slate-200 bg-white shadow-sm overflow-hidden">
                        <div class="border-b border-slate-100 bg-slate-50/60 px-6 py-5">
                            <h3 class="text-xl font-extrabold text-slate-900">Riwayat Pengeluaran</h3>
                            <p class="mt-0.5 text-sm text-slate-500">Struk digital — bukti transaksi tersimpan permanen.</p>
                        </div>
                        @if($pengeluaranList->isEmpty())
                            <div class="flex flex-col items-center gap-3 py-16 text-slate-400">
                                <i data-lucide="file-x" class="h-10 w-10"></i>
                                <p class="text-sm font-medium">Belum ada catatan pengeluaran.</p>
                            </div>
                        @else
                            <div class="divide-y divide-slate-100">
                                @foreach($pengeluaranList as $item)
                                    <div class="flex items-start gap-4 px-6 py-5 transition hover:bg-slate-50/60">
                                        <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-slate-200 bg-slate-100 text-slate-400">
                                            @if($item->foto_struk)
                                                <a href="{{ asset('storage/' . $item->foto_struk) }}" target="_blank" rel="noopener noreferrer">
                                                    <img src="{{ asset('storage/' . $item->foto_struk) }}" alt="Struk" class="h-14 w-14 object-cover transition hover:opacity-80">
                                                </a>
                                            @else
                                                <i data-lucide="image-off" class="h-5 w-5"></i>
                                            @endif
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-start justify-between gap-3">
                                                <div>
                                                    <p class="font-bold text-slate-900">{{ $item->keperluan }}</p>
                                                    <p class="mt-0.5 text-xs font-medium text-slate-500">
                                                        {{ $item->tanggal->translatedFormat('d F Y') }}
                                                    </p>
                                                </div>
                                                <p class="whitespace-nowrap font-black text-rose-600">
                                                    - Rp {{ number_format($item->nominal, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            @if($item->catatan)
                                                <p class="mt-2 rounded-lg border border-slate-100 bg-slate-50 px-3 py-2 text-sm leading-relaxed text-slate-600">
                                                    {{ $item->catatan }}
                                                </p>
                                            @endif
                                        </div>
                                        <form action="{{ route('admin.kas.pengeluaran.destroy', $item) }}" method="POST"
                                            onsubmit="return confirm('Hapus catatan pengeluaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-slate-200 text-slate-400 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-500">
                                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        function toggleSemuaIuran(status) {
            document.querySelectorAll('input[name="sudah_bayar[]"]').forEach(cb => {
                cb.checked = status;
                const label = cb.closest('label');
                if (label) {
                    if (status) {
                        label.classList.add('border-emerald-200', 'bg-emerald-50');
                        label.classList.remove('border-transparent');
                    } else {
                        label.classList.remove('border-emerald-200', 'bg-emerald-50');
                        label.classList.add('border-transparent');
                    }
                }
            });
        }

        function toggleFormLibur() {
            const panel = document.getElementById('formLiburPanel');
            const icon = document.getElementById('iconChevronLibur');
            panel.classList.toggle('hidden');
            icon.style.transform = panel.classList.contains('hidden') ? '' : 'rotate(180deg)';
        }
    </script>
</x-app-layout>
