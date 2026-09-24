<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KajianAttendance;
use App\Models\KasIuran;
use App\Models\PiketMember;
use App\Models\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KajianController extends Controller
{
    /**
     * Halaman absensi kajian — tampilkan daftar jadwal & ceklis kehadiran.
     */
    public function index(Request $request): View
    {
        // Semua jadwal yang tidak dibatalkan, terbaru di atas
        $schedules = Schedule::where('status', '!=', 'cancelled')
            ->orderByDesc('event_date')
            ->get();

        // Default ke jadwal paling dekat (sudah lewat atau hari ini)
        $selectedId = $request->get('schedule_id');
        $selectedSchedule = null;

        if ($selectedId) {
            $selectedSchedule = Schedule::find($selectedId);
        } elseif ($schedules->isNotEmpty()) {
            // Pilih otomatis: jadwal terdekat yang sudah lewat
            $selectedSchedule = $schedules->first(fn ($s) => $s->event_date->isPast() || $s->event_date->isToday())
                ?? $schedules->first();
        }

        $members = PiketMember::orderBy('gender')->orderBy('name')->get();

        // Kehadiran yang sudah tersimpan untuk jadwal ini
        $hadirMap = collect();
        $hadirCount = 0;

        if ($selectedSchedule) {
            $hadirMap = KajianAttendance::where('schedule_id', $selectedSchedule->id)
                ->pluck('hadir', 'piket_member_id');
            $hadirCount = $hadirMap->filter()->count();
        }

        return view('admin.kajian.index', compact(
            'schedules',
            'selectedSchedule',
            'members',
            'hadirMap',
            'hadirCount',
        ));
    }

    /**
     * Simpan absensi kajian + auto-sync kas iuran untuk yang hadir.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'schedule_id' => ['required', 'exists:schedules,id'],
        ]);

        $schedule = Schedule::findOrFail($request->input('schedule_id'));
        $hadirIds = $request->input('hadir', []);
        $allMembers = PiketMember::pluck('id');
        $tanggal = $schedule->event_date->toDateString();

        foreach ($allMembers as $memberId) {
            $isHadir = in_array($memberId, $hadirIds);

            // Simpan/update absensi kajian
            KajianAttendance::updateOrCreate(
                ['schedule_id' => $schedule->id, 'piket_member_id' => $memberId],
                ['hadir' => $isHadir],
            );

            // Auto-sync kas iuran: yang hadir → sudah bayar
            // Yang tidak hadir TIDAK diubah — mungkin sudah bayar manual
            if ($isHadir) {
                KasIuran::updateOrCreate(
                    ['piket_member_id' => $memberId, 'tanggal_pertemuan' => $tanggal],
                    [
                        'nominal' => 2000,
                        'sudah_bayar' => true,
                        'status_pertemuan' => 'rekap',
                        'keterangan_libur' => null,
                    ],
                );
            }
        }

        return redirect()
            ->route('admin.kajian.index', ['schedule_id' => $schedule->id])
            ->with('success', 'Absensi kajian "'.$schedule->title.'" berhasil disimpan. '.count($hadirIds).' anggota hadir, iuran otomatis ditandai lunas.');
    }

    /**
     * Reset absensi satu jadwal (hapus semua row kajian_attendances-nya).
     * Kas iuran TIDAK dihapus — harus reset manual dari halaman Kas.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate(['schedule_id' => ['required', 'exists:schedules,id']]);

        $schedule = Schedule::findOrFail($request->input('schedule_id'));
        KajianAttendance::where('schedule_id', $schedule->id)->delete();

        return redirect()
            ->route('admin.kajian.index', ['schedule_id' => $schedule->id])
            ->with('success', 'Absensi kajian "'.$schedule->title.'" berhasil direset. Data kas iuran tidak diubah.');
    }
}
