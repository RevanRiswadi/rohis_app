<?php

namespace App\Http\Controllers;

use App\Models\KasIuran;
use App\Models\KasPengeluaran;
use App\Models\PiketMember;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class KasController extends Controller
{
    /**
     * Generate semua tanggal Sabtu dari awal tahun ini sampai Sabtu mendatang.
     *
     * @return Collection<int, Carbon>
     */
    private function generateDaftarSabtu(): Collection
    {
        $mulai = Carbon::now()->startOfYear();
        $akhir = Carbon::now()->addWeeks(1)->endOfWeek(); // satu minggu ke depan

        // Geser ke Sabtu pertama
        if ($mulai->dayOfWeek !== Carbon::SATURDAY) {
            $mulai->next(Carbon::SATURDAY);
        }

        $sabtuList = collect();
        $cursor = $mulai->copy();

        while ($cursor->lte($akhir)) {
            $sabtuList->push($cursor->copy());
            $cursor->addWeek();
        }

        return $sabtuList->sortDesc()->values();
    }

    /**
     * Halaman utama Kas & Infaq.
     */
    public function index(Request $request): View
    {
        $tab = $request->get('tab', 'iuran');

        // --- Daftar Sabtu otomatis ---
        $daftarSabtu = $this->generateDaftarSabtu();

        // Default pilih Sabtu terdekat yang sudah lewat (atau hari ini kalau Sabtu)
        $defaultTanggal = $daftarSabtu->first(fn ($s) => $s->isPast() || $s->isToday())
            ?? $daftarSabtu->last();

        $tanggalPertemuan = $request->get('tanggal', $defaultTanggal->toDateString());

        $members = PiketMember::orderBy('gender')->orderBy('name')->get();

        // Status pertemuan yang sudah punya data (rekap/libur)
        $statusPertemuan = KasIuran::select('tanggal_pertemuan', 'status_pertemuan', 'keterangan_libur')
            ->distinct()
            ->get()
            ->keyBy(fn ($r) => $r->tanggal_pertemuan->toDateString());

        // Data ceklis untuk pertemuan yang dipilih
        $iuranHariIni = KasIuran::where('tanggal_pertemuan', $tanggalPertemuan)
            ->pluck('sudah_bayar', 'piket_member_id');

        $statusDipilih = $statusPertemuan->get($tanggalPertemuan);

        // --- TAB REKAP ---
        $tahunDipilih = (int) $request->get('tahun', Carbon::now()->year);
        $bulanDipilih = (int) $request->get('bulan', Carbon::now()->month);

        $rekapBulanan = KasIuran::whereYear('tanggal_pertemuan', $tahunDipilih)
            ->whereMonth('tanggal_pertemuan', $bulanDipilih)
            ->with('member')
            ->get()
            ->groupBy('piket_member_id');

        $pertemuanBulanIni = KasIuran::whereYear('tanggal_pertemuan', $tahunDipilih)
            ->whereMonth('tanggal_pertemuan', $bulanDipilih)
            ->where('status_pertemuan', 'rekap')
            ->select('tanggal_pertemuan')
            ->distinct()
            ->orderBy('tanggal_pertemuan')
            ->pluck('tanggal_pertemuan');

        $rekapTahunan = KasIuran::whereYear('tanggal_pertemuan', $tahunDipilih)
            ->where('status_pertemuan', 'rekap')
            ->selectRaw('piket_member_id, SUM(nominal) as total_bayar, SUM(sudah_bayar) as hadir_bayar')
            ->groupBy('piket_member_id')
            ->with('member')
            ->get();

        $tahunTersedia = KasIuran::selectRaw('YEAR(tanggal_pertemuan) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        // Saldo
        $totalIuranMasuk = KasIuran::where('sudah_bayar', true)
            ->where('status_pertemuan', 'rekap')
            ->sum('nominal');
        $totalPengeluaran = KasPengeluaran::sum('nominal');
        $saldoAkhir = $totalIuranMasuk - $totalPengeluaran;

        // --- TAB PENGELUARAN ---
        $pengeluaranList = KasPengeluaran::orderByDesc('tanggal')->orderByDesc('id')->get();

        return view('admin.kas.index', compact(
            'tab',
            'members',
            'tanggalPertemuan',
            'daftarSabtu',
            'statusPertemuan',
            'iuranHariIni',
            'statusDipilih',
            'rekapBulanan',
            'pertemuanBulanIni',
            'rekapTahunan',
            'tahunTersedia',
            'tahunDipilih',
            'bulanDipilih',
            'totalIuranMasuk',
            'totalPengeluaran',
            'saldoAkhir',
            'pengeluaranList',
        ));
    }

    /**
     * Simpan ceklis iuran (rekap normal).
     */
    public function storeIuran(Request $request): RedirectResponse
    {
        $request->validate([
            'tanggal_pertemuan' => ['required', 'date'],
        ]);

        $tanggal = $request->input('tanggal_pertemuan');
        $sudahBayarIds = $request->input('sudah_bayar', []);
        $allMembers = PiketMember::pluck('id');

        foreach ($allMembers as $memberId) {
            KasIuran::updateOrCreate(
                ['piket_member_id' => $memberId, 'tanggal_pertemuan' => $tanggal],
                [
                    'nominal' => 2000,
                    'sudah_bayar' => in_array($memberId, $sudahBayarIds),
                    'status_pertemuan' => 'rekap',
                    'keterangan_libur' => null,
                ]
            );
        }

        return redirect()
            ->route('admin.kas.index', ['tab' => 'iuran', 'tanggal' => $tanggal])
            ->with('success', 'Iuran pertemuan '.Carbon::parse($tanggal)->translatedFormat('d M Y').' berhasil disimpan.');
    }

    /**
     * Tandai satu Sabtu sebagai libur.
     * Hapus row anggota jika ada, simpan satu row penanda libur dengan member_id = 0 tidak bisa,
     * jadi pakai member pertama sebagai penanda dan set sudah_bayar = false untuk semua.
     */
    public function storeLibur(Request $request): RedirectResponse
    {
        $request->validate([
            'tanggal_pertemuan' => ['required', 'date'],
            'keterangan_libur' => ['nullable', 'string', 'max:255'],
        ]);

        $tanggal = $request->input('tanggal_pertemuan');
        $keterangan = $request->input('keterangan_libur', 'Pertemuan diliburkan');
        $allMembers = PiketMember::pluck('id');

        // Hapus data rekap lama kalau ada, ganti dengan status libur
        KasIuran::where('tanggal_pertemuan', $tanggal)->delete();

        // Simpan satu baris per anggota dengan status libur & sudah_bayar = false
        foreach ($allMembers as $memberId) {
            KasIuran::create([
                'piket_member_id' => $memberId,
                'tanggal_pertemuan' => $tanggal,
                'nominal' => 0,
                'sudah_bayar' => false,
                'status_pertemuan' => 'libur',
                'keterangan_libur' => $keterangan,
            ]);
        }

        return redirect()
            ->route('admin.kas.index', ['tab' => 'iuran', 'tanggal' => $tanggal])
            ->with('success', 'Pertemuan '.Carbon::parse($tanggal)->translatedFormat('d M Y').' ditandai libur.');
    }

    /**
     * Hapus seluruh data satu pertemuan (reset ke "belum diisi").
     */
    public function destroyIuran(Request $request): RedirectResponse
    {
        $request->validate(['tanggal_pertemuan' => ['required', 'date']]);

        KasIuran::where('tanggal_pertemuan', $request->input('tanggal_pertemuan'))->delete();

        return redirect()
            ->route('admin.kas.index', ['tab' => 'iuran'])
            ->with('success', 'Data pertemuan '.Carbon::parse($request->input('tanggal_pertemuan'))->translatedFormat('d M Y').' dihapus.');
    }

    /**
     * Simpan pencatatan pengeluaran + foto struk opsional.
     */
    public function storePengeluaran(Request $request): RedirectResponse
    {
        $request->validate([
            'tanggal' => ['required', 'date'],
            'keperluan' => ['required', 'string', 'max:255'],
            'nominal' => ['required', 'integer', 'min:1'],
            'catatan' => ['nullable', 'string', 'max:1000'],
            'foto_struk' => ['nullable', 'image', 'max:3072'],
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_struk')) {
            $fotoPath = $request->file('foto_struk')->store('kas/struk', 'public');
        }

        KasPengeluaran::create([
            'tanggal' => $request->input('tanggal'),
            'keperluan' => $request->input('keperluan'),
            'nominal' => $request->input('nominal'),
            'catatan' => $request->input('catatan'),
            'foto_struk' => $fotoPath,
        ]);

        return redirect()
            ->route('admin.kas.index', ['tab' => 'pengeluaran'])
            ->with('success', 'Pengeluaran berhasil dicatat.');
    }

    /**
     * Hapus catatan pengeluaran beserta foto struk-nya.
     */
    public function destroyPengeluaran(KasPengeluaran $pengeluaran): RedirectResponse
    {
        if ($pengeluaran->foto_struk) {
            Storage::disk('public')->delete($pengeluaran->foto_struk);
        }

        $pengeluaran->delete();

        return redirect()
            ->route('admin.kas.index', ['tab' => 'pengeluaran'])
            ->with('success', 'Catatan pengeluaran dihapus.');
    }
}
