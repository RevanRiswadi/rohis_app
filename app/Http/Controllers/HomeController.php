<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Officer;
use App\Models\PiketMember;
use App\Models\Registration;
use App\Models\Schedule;
use App\Models\Setting; // <-- Tambahan Model Piket
use Carbon\Carbon; // <-- Tambahan untuk mendeteksi waktu/hari

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

        $activeMembers = Registration::where('status', 'accepted')->count();
        $totalPrograms = Schedule::where('status', '!=', 'cancelled')->count();
        $galleries = Gallery::where('is_active', true)->latest()->take(6)->get();

        // ==========================================
        // TAMBAHAN LOGIKA PIKET MASJID OTOMATIS
        // ==========================================
        $hariIni = Carbon::now()->locale('id')->dayName; // Mendapatkan nama hari (Contoh: 'Senin', 'Selasa')
        $piketHariIni = collect(); // Set default kosong

        // Cek jika hari ini adalah Senin atau Kamis
        if (in_array($hariIni, ['Senin', 'Kamis'])) {
            $piketHariIni = PiketMember::where('day', $hariIni)->get();
        }
        // ==========================================

        return view('welcome', compact(
            'heroImage', 'socialInstagram', 'socialWhatsapp', 'socialYoutube',
            'officers', 'schedules', 'faqs', 'activeMembers', 'totalPrograms', 'galleries',
            'hariIni', 'piketHariIni' // <-- Tambahan 2 variabel Piket untuk dikirim ke View
        ));
    }

    public function showSchedule(Schedule $schedule)
    {
        return view('schedule.show', compact('schedule'));
    }

    public function allSchedules()
    {
        return redirect()->to(route('home').'#kegiatan');
    }

    public function allOfficers()
    {
        $officers = Officer::orderBy('order_priority')->get();
        $socialInstagram = Setting::get('social_instagram', 'https://instagram.com/rohis.sekolah');
        $socialWhatsapp = Setting::get('social_whatsapp', 'https://wa.me/6281234567890');
        $socialYoutube = Setting::get('social_youtube', 'https://youtube.com/@rohis.sekolah');

        return view('officer.index', compact('officers', 'socialInstagram', 'socialWhatsapp', 'socialYoutube'));
    }

    public function createRegistration()
    {
        $socialInstagram = Setting::get('social_instagram', 'https://instagram.com/rohis.sekolah');
        $socialWhatsapp = Setting::get('social_whatsapp', 'https://wa.me/6281234567890');
        $socialYoutube = Setting::get('social_youtube', 'https://youtube.com/@rohis.sekolah');

        return view('register', compact('socialInstagram', 'socialWhatsapp', 'socialYoutube'));
    }

    public function storeRegistration(StoreRegistrationRequest $request)
    {
        Registration::create($request->validated());

        return redirect()->back()->with('success', 'Pendaftaran berhasil dikirim! Silakan tunggu info selanjutnya.');
    }
}
