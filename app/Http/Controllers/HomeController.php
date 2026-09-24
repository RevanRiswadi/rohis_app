<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Announcement;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Officer;
use App\Models\PiketMember;
use App\Models\Registration;
use App\Models\Schedule;
use App\Models\Setting;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index()
    {
        $heroImage = Setting::get('hero_image');
        $socialInstagram = Setting::get('social_instagram', 'https://instagram.com/rohis.sekolah');
        $socialWhatsapp = Setting::get('social_whatsapp', 'https://wa.me/6281234567890');
        $socialYoutube = Setting::get('social_youtube', 'https://youtube.com/@rohis.sekolah');
        $officers = Officer::orderBy('order_priority')->get();
        $schedules = Schedule::where('status', '!=', 'cancelled')->orderBy('event_date', 'desc')->get();
        $faqs = Faq::orderBy('order_priority')->get();
        $galleries = Gallery::where('is_active', true)->latest()->take(6)->get();

        // Pengumuman terbaru yang dipublish — tampil max 3 di homepage
        $announcements = Announcement::where('is_published', true)
            ->latest()
            ->take(3)
            ->get();

        $activeMembers = Registration::where('status', 'accepted')->count();
        $totalPrograms = Schedule::where('status', '!=', 'cancelled')->count();

        // Override statistik dari Setting jika admin sudah set manual
        $statAnggota = Setting::get('stat_anggota') ?? $activeMembers.'+';
        $statProgram = Setting::get('stat_program') ?? $totalPrograms.'+';
        $statKajian = Setting::get('stat_kajian', 'Rutin');
        $statUkhuwah = Setting::get('stat_ukhuwah', '100%');
        $statAnggotaLabel = Setting::get('stat_anggota_label', 'Anggota Aktif');
        $statProgramLabel = Setting::get('stat_program_label', 'Program Kegiatan');
        $statKajianLabel = Setting::get('stat_kajian_label', 'Kajian Mingguan');
        $statUkhuwahLabel = Setting::get('stat_ukhuwah_label', 'Ukhuwah');

        $hariIni = Carbon::now()->locale('id')->dayName;
        $piketHariIni = collect();

        if (in_array($hariIni, ['Senin', 'Kamis'])) {
            $piketHariIni = PiketMember::where('day', $hariIni)->get();
        }

        return view('welcome', compact(
            'heroImage', 'socialInstagram', 'socialWhatsapp', 'socialYoutube',
            'officers', 'schedules', 'faqs', 'activeMembers', 'totalPrograms', 'galleries',
            'announcements',
            'hariIni', 'piketHariIni',
            'statAnggota', 'statProgram', 'statKajian', 'statUkhuwah',
            'statAnggotaLabel', 'statProgramLabel', 'statKajianLabel', 'statUkhuwahLabel',
        ));
    }

    public function showSchedule(Schedule $schedule): View
    {
        return view('schedule.show', compact('schedule'));
    }

    public function allSchedules(): RedirectResponse
    {
        return redirect()->to(route('home').'#kegiatan');
    }

    public function allOfficers(): View
    {
        $officers = Officer::orderBy('order_priority')->get();
        $socialInstagram = Setting::get('social_instagram', 'https://instagram.com/rohis.sekolah');
        $socialWhatsapp = Setting::get('social_whatsapp', 'https://wa.me/6281234567890');
        $socialYoutube = Setting::get('social_youtube', 'https://youtube.com/@rohis.sekolah');

        return view('officer.index', compact('officers', 'socialInstagram', 'socialWhatsapp', 'socialYoutube'));
    }

    public function allAnnouncements(): View
    {
        $announcements = Announcement::where('is_published', true)
            ->latest()
            ->paginate(9);

        $socialInstagram = Setting::get('social_instagram', 'https://instagram.com/rohis.sekolah');
        $socialWhatsapp = Setting::get('social_whatsapp', 'https://wa.me/6281234567890');
        $socialYoutube = Setting::get('social_youtube', 'https://youtube.com/@rohis.sekolah');

        return view('announcement.index', compact('announcements', 'socialInstagram', 'socialWhatsapp', 'socialYoutube'));
    }

    public function showAnnouncement(Announcement $announcement): View
    {
        abort_if(! $announcement->is_published, 404);

        $socialInstagram = Setting::get('social_instagram', 'https://instagram.com/rohis.sekolah');
        $socialWhatsapp = Setting::get('social_whatsapp', 'https://wa.me/6281234567890');
        $socialYoutube = Setting::get('social_youtube', 'https://youtube.com/@rohis.sekolah');

        return view('announcement.show', compact('announcement', 'socialInstagram', 'socialWhatsapp', 'socialYoutube'));
    }

    public function createRegistration(): View
    {
        $socialInstagram = Setting::get('social_instagram', 'https://instagram.com/rohis.sekolah');
        $socialWhatsapp = Setting::get('social_whatsapp', 'https://wa.me/6281234567890');
        $socialYoutube = Setting::get('social_youtube', 'https://youtube.com/@rohis.sekolah');

        return view('register', compact('socialInstagram', 'socialWhatsapp', 'socialYoutube'));
    }

    public function storeRegistration(StoreRegistrationRequest $request): RedirectResponse
    {
        $registration = Registration::create($request->validated());

        // Kirim notif WA ke admin — gagal diam-diam agar pendaftaran tetap sukses
        app(WhatsAppService::class)->notifyNewRegistration(
            fullName: $registration->full_name,
            class: $registration->class,
            major: $registration->major,
            preferredDivision: $registration->preferred_division,
            whatsappNumber: $registration->whatsapp_number,
        );

        return redirect()->back()->with('success', 'Pendaftaran berhasil dikirim! Silakan tunggu info selanjutnya.');
    }
}
