<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PiketAttendance;
use App\Models\PiketMember;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PiketController extends Controller
{
    public function index(Request $request)
    {
        // Default ke hari ini jika admin tidak memilih tanggal
        $date = $request->date ?? Carbon::today()->toDateString();

        // Memastikan nama hari diterjemahkan secara akurat ke bahasa Indonesia
        $englishDay = Carbon::parse($date)->format('l'); // Monday, Thursday, dll
        $dayName = ($englishDay == 'Monday') ? 'Senin' : (($englishDay == 'Thursday') ? 'Kamis' : $englishDay);

        $members = collect();
        $waText = ''; // Siapkan variabel untuk pesan WhatsApp

        // Hanya ambil data jika hari yang dipilih adalah Senin atau Kamis
        if (in_array($dayName, ['Senin', 'Kamis'])) {
            $members = PiketMember::where('day', $dayName)->get();

            // Membuat Format Pesan WhatsApp Otomatis (100% BERSIH DARI EMOJI)
            $tanggalIndo = Carbon::parse($date)->locale('id')->isoFormat('D MMMM YYYY');
            $pesan = "*PENGINGAT PIKET MASJID*\n\n";
            $pesan .= "Assalamu'alaikum wr. wb.\n";
            $pesan .= "Mengingatkan untuk teman-teman petugas piket hari ini (*$dayName, $tanggalIndo*):\n\n";

            $pesan .= "*IKHWAN:*\n";
            $noIkhwan = 1;
            foreach ($members->where('gender', 'Ikhwan') as $m) {
                $pesan .= $noIkhwan.'. '.$m->name."\n";
                $noIkhwan++;
            }

            $pesan .= "\n*AKHWAT:*\n";
            $noAkhwat = 1;
            foreach ($members->where('gender', 'Akhwat') as $m) {
                $pesan .= $noAkhwat.'. '.$m->name."\n";
                $noAkhwat++;
            }

            $pesan .= "\nMohon kehadirannya tepat waktu ya! Semangat meraih pahala!";

            // Gunakan rawurlencode agar spasi dan karakter terbaca sempurna di WA
            $waText = rawurlencode($pesan);
        }

        // Ambil data absen yang sudah tersimpan di tanggal ini (jika ada)
        $attendances = PiketAttendance::where('date', $date)->pluck('is_present', 'piket_member_id')->toArray();

        return view('admin.piket.index', compact('date', 'dayName', 'members', 'attendances', 'waText'));
    }

    public function store(Request $request)
    {
        $date = $request->date;
        $presentIds = $request->piket_member_ids ?? []; // Array ID yang di-ceklis admin

        $englishDay = Carbon::parse($date)->format('l');
        $dayName = ($englishDay == 'Monday') ? 'Senin' : (($englishDay == 'Thursday') ? 'Kamis' : $englishDay);

        $members = PiketMember::where('day', $dayName)->get();

        foreach ($members as $member) {
            // Update jika sudah ada, atau Buat baru jika belum ada
            PiketAttendance::updateOrCreate(
                ['piket_member_id' => $member->id, 'date' => $date],
                ['is_present' => in_array($member->id, $presentIds)]
            );
        }

        return redirect()->back()->with('success', 'Absensi piket untuk tanggal '.Carbon::parse($date)->format('d-m-Y').' berhasil disimpan!');
    }

    public function statistics()
    {
        // Menghitung total kehadiran setiap anggota
        $members = PiketMember::withCount(['attendances' => function ($query) {
            $query->where('is_present', true);
        }])->orderByDesc('attendances_count')->get();

        return view('admin.piket.statistics', compact('members'));
    }

    // Menampilkan halaman kelola anggota piket
    public function members()
    {
        // Dikembalikan ke variabel asli agar view tidak error
        $ikhwan = PiketMember::where('gender', 'Ikhwan')->orderBy('name')->get();
        $akhwat = PiketMember::where('gender', 'Akhwat')->orderBy('name')->get();

        return view('admin.piket.members', compact('ikhwan', 'akhwat'));
    }

    // Menyimpan perubahan rombak jadwal secara massal
    public function updateMembers(Request $request)
    {
        // Update hari piket massal tanpa perlu ngetik manual
        if ($request->has('days')) {
            foreach ($request->days as $id => $day) {
                PiketMember::where('id', $id)->update(['day' => $day]);
            }
        }

        return redirect()->back()->with('success', 'Perubahan jadwal / rombak anggota piket berhasil disimpan!');
    }
}
