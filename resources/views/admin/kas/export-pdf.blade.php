<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Kas {{ $namaBulan }} {{ $tahun }} — Rohis Darul Muttaqin</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            font-size: 12px;
            color: #1e293b;
            background: #fff;
            padding: 32px;
        }

        /* HEADER */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #059669;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }
        .header-left { display: flex; align-items: center; gap: 12px; }
        .header-left img { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; }
        .header-title { font-size: 18px; font-weight: 900; color: #0f172a; line-height: 1.2; }
        .header-sub { font-size: 11px; color: #059669; font-weight: 600; margin-top: 2px; }
        .header-right { text-align: right; }
        .header-right .doc-title { font-size: 14px; font-weight: 800; color: #059669; }
        .header-right .doc-period { font-size: 12px; color: #64748b; margin-top: 2px; }
        .header-right .doc-date { font-size: 11px; color: #94a3b8; margin-top: 2px; }

        /* SUMMARY CARDS */
        .summary { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 24px; }
        .summary-card {
            border-radius: 10px;
            padding: 14px 16px;
            border: 1px solid #e2e8f0;
        }
        .summary-card.green { background: #f0fdf4; border-color: #bbf7d0; }
        .summary-card.red   { background: #fff1f2; border-color: #fecdd3; }
        .summary-card.dark  { background: #0f172a; border-color: #0f172a; color: #fff; }
        .summary-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #64748b; }
        .summary-card.dark .summary-label { color: #94a3b8; }
        .summary-value { font-size: 18px; font-weight: 900; margin-top: 4px; color: #0f172a; }
        .summary-card.green .summary-value { color: #059669; }
        .summary-card.red   .summary-value { color: #e11d48; }
        .summary-card.dark  .summary-value { color: #34d399; }

        /* SECTION TITLE */
        .section-title {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #059669;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 1px solid #d1fae5;
        }

        /* TABLES */
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; font-size: 11px; }
        thead tr { background: #f8fafc; }
        th {
            text-align: left;
            padding: 8px 10px;
            font-weight: 700;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }
        th.center { text-align: center; }
        th.right  { text-align: right; }
        td { padding: 7px 10px; border-bottom: 1px solid #f1f5f9; color: #334155; }
        td.center { text-align: center; }
        td.right  { text-align: right; }
        tr:last-child td { border-bottom: none; }
        .check { color: #059669; font-weight: 800; }
        .dash  { color: #cbd5e1; }
        .badge-ikhwan { color: #2563eb; font-weight: 700; }
        .badge-akhwat { color: #7c3aed; font-weight: 700; }
        .total-row td { font-weight: 800; background: #f8fafc; border-top: 2px solid #e2e8f0; }
        .libur-row td { background: #fffbeb; color: #92400e; font-style: italic; }

        /* PENGELUARAN */
        .neg { color: #e11d48; font-weight: 700; }

        /* FOOTER */
        .footer {
            margin-top: 32px;
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #94a3b8;
            font-size: 10px;
        }
        .ttd-area {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
            margin-top: 40px;
        }
        .ttd-box { text-align: center; }
        .ttd-label { font-size: 11px; font-weight: 600; color: #475569; }
        .ttd-line { margin-top: 52px; border-top: 1px solid #334155; padding-top: 6px; font-size: 11px; color: #0f172a; font-weight: 700; }

        /* PRINT */
        @media print {
            body { padding: 20px; }
            .no-print { display: none !important; }
            @page { margin: 1cm; size: A4; }
        }

        /* ACTION BAR (screen only) */
        .action-bar {
            position: fixed;
            bottom: 24px;
            right: 24px;
            display: flex;
            gap: 10px;
            z-index: 100;
        }
        .btn-print {
            background: #059669;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 12px 22px;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap-6px;
            box-shadow: 0 4px 16px rgba(5,150,105,0.35);
            transition: background 0.15s;
        }
        .btn-print:hover { background: #047857; }
        .btn-back {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 18px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .btn-back:hover { background: #e2e8f0; }
    </style>
</head>
<body>

    {{-- Action bar (screen only) --}}
    <div class="action-bar no-print">
        <a href="{{ route('admin.kas.index', ['tab' => 'rekap', 'bulan' => $bulan, 'tahun' => $tahun]) }}"
           class="btn-back">← Kembali</a>
        <button class="btn-print" onclick="window.print()">🖨 Cetak / Simpan PDF</button>
    </div>

    {{-- Header --}}
    <div class="header">
        <div class="header-left">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <div>
                <div class="header-title">Rohis Darul Muttaqin</div>
                <div class="header-sub">Organisasi Kerohanian Islam</div>
            </div>
        </div>
        <div class="header-right">
            <div class="doc-title">Laporan Kas & Iuran</div>
            <div class="doc-period">{{ $namaBulan }} {{ $tahun }}</div>
            <div class="doc-date">Dicetak: {{ now()->translatedFormat('d F Y, H:i') }}</div>
        </div>
    </div>

    {{-- Summary --}}
    <div class="summary">
        <div class="summary-card green">
            <div class="summary-label">Total Iuran Masuk</div>
            <div class="summary-value">Rp {{ number_format($totalIuranBulan, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card red">
            <div class="summary-label">Total Pengeluaran</div>
            <div class="summary-value">Rp {{ number_format($totalPengeluaranBulan, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card dark">
            <div class="summary-label">Saldo Bulan Ini</div>
            <div class="summary-value">Rp {{ number_format($saldoBulan, 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- Rekap Iuran --}}
    <div class="section-title">Rekap Iuran Mingguan — {{ $namaBulan }} {{ $tahun }}</div>

    @if($pertemuanBulan->isEmpty())
        <p style="color:#94a3b8; font-style:italic; margin-bottom:24px;">Tidak ada data iuran bulan ini.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Anggota</th>
                    <th class="center">Jenis</th>
                    @foreach($pertemuanBulan as $tgl)
                        <th class="center">{{ \Carbon\Carbon::parse($tgl)->format('d/m') }}</th>
                    @endforeach
                    <th class="center">Lunas</th>
                    <th class="right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $i => $member)
                    @php
                        $iuranMember = $iuranBulan->get($member->id, collect());
                        $byTgl = $iuranMember->keyBy(fn($r) => $r->tanggal_pertemuan->toDateString());
                        $lunasCount = $iuranMember->where('sudah_bayar', true)->count();
                        $totalBayar = $iuranMember->where('sudah_bayar', true)->sum('nominal');
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><strong>{{ $member->name }}</strong></td>
                        <td class="center">
                            <span class="{{ $member->gender === 'Ikhwan' ? 'badge-ikhwan' : 'badge-akhwat' }}">
                                {{ $member->gender }}
                            </span>
                        </td>
                        @foreach($pertemuanBulan as $tgl)
                            @php $rec = $byTgl->get($tgl->toDateString()); @endphp
                            <td class="center">
                                @if($rec && $rec->sudah_bayar)
                                    <span class="check">✓</span>
                                @elseif($rec)
                                    <span class="dash">–</span>
                                @else
                                    <span class="dash">·</span>
                                @endif
                            </td>
                        @endforeach
                        <td class="center">{{ $lunasCount }}/{{ $pertemuanBulan->count() }}</td>
                        <td class="right">Rp {{ number_format($totalBayar, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="{{ 3 + $pertemuanBulan->count() }}" class="right">Total Iuran Masuk</td>
                    <td class="right" colspan="2">Rp {{ number_format($totalIuranBulan, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    @endif

    {{-- Pengeluaran --}}
    <div class="section-title">Rincian Pengeluaran — {{ $namaBulan }} {{ $tahun }}</div>

    @if($pengeluaranBulan->isEmpty())
        <p style="color:#94a3b8; font-style:italic; margin-bottom:24px;">Tidak ada pengeluaran bulan ini.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Keperluan</th>
                    <th>Catatan</th>
                    <th class="right">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengeluaranBulan as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->tanggal->translatedFormat('d M Y') }}</td>
                        <td><strong>{{ $item->keperluan }}</strong></td>
                        <td style="color:#64748b;">{{ $item->catatan ?? '—' }}</td>
                        <td class="right neg">– Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="4" class="right">Total Pengeluaran</td>
                    <td class="right neg">– Rp {{ number_format($totalPengeluaranBulan, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    @endif

    {{-- Tanda tangan --}}
    <div class="ttd-area">
        <div class="ttd-box">
            <div class="ttd-label">Mengetahui,<br>Pembina Rohis</div>
            <div class="ttd-line">( _________________________ )</div>
        </div>
        <div class="ttd-box">
            <div class="ttd-label">Bendahara Rohis</div>
            <div class="ttd-line">( _________________________ )</div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <span>Rohis Darul Muttaqin — Dokumen Keuangan Internal</span>
        <span>Dicetak oleh sistem pada {{ now()->translatedFormat('d F Y') }}</span>
    </div>

</body>
</html>
