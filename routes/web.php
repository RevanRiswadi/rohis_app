<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HomepageTextController;
use App\Http\Controllers\Admin\KajianController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\OfficerController;
use App\Http\Controllers\Admin\PiketController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KasController;
use Illuminate\Support\Facades\Route;

// Halaman Publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kegiatan', [HomeController::class, 'allSchedules'])->name('schedule.index');
Route::get('/kegiatan/{schedule}', [HomeController::class, 'showSchedule'])->name('schedule.show');
Route::get('/pengurus', [HomeController::class, 'allOfficers'])->name('officer.index');
Route::get('/pengumuman', [HomeController::class, 'allAnnouncements'])->name('announcement.index');
Route::get('/pengumuman/{announcement:slug}', [HomeController::class, 'showAnnouncement'])->name('announcement.show');

// Handle Form & Submit Pendaftaran
Route::get('/daftar', [HomeController::class, 'createRegistration'])->name('register.create');
Route::post('/daftar', [HomeController::class, 'storeRegistration'])->name('register.store');

// Redirect default login Laravel (/dashboard) ke Admin Panel (/admin/dashboard)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');
});

// Area Admin Panel (Wajib Login)
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kelola Pengurus & Jadwal
    Route::resource('officers', OfficerController::class)->only(['index', 'show', 'store', 'edit', 'update', 'destroy']);
    Route::resource('schedules', ScheduleController::class);
    Route::resource('announcements', AnnouncementController::class)->except(['show']);

    // Kelola Pendaftaran & Export Excel (Export wajib di atas resource)
    Route::get('/registrations/export', [RegistrationController::class, 'export'])->name('registrations.export');
    Route::resource('registrations', RegistrationController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);

    // Kelola Anggota Resmi & Galeri Kegiatan
    Route::resource('members', MemberController::class)->only(['index', 'update', 'destroy']);
    Route::resource('galleries', GalleryController::class)->except(['create', 'show', 'edit']);

    // Kelola Foto Hero & Pengaturan Web
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::delete('/settings/hero', [SettingController::class, 'destroy'])->name('settings.destroy');

    // Kelola Piket Masjid
    Route::get('/piket', [PiketController::class, 'index'])->name('piket.index');
    Route::post('/piket', [PiketController::class, 'store'])->name('piket.store');
    Route::get('/piket/statistik', [PiketController::class, 'statistics'])->name('piket.statistics');
    Route::get('/piket/anggota', [PiketController::class, 'members'])->name('piket.members');
    Route::post('/piket/anggota', [PiketController::class, 'updateMembers'])->name('piket.updateMembers');
    Route::post('/piket/anggota/tambah', [PiketController::class, 'storeMember'])->name('piket.members.store');
    Route::delete('/piket/anggota/{member}', [PiketController::class, 'destroyMember'])->name('piket.members.destroy');

    // Kelola Teks Beranda
    Route::get('/teks-beranda', [HomepageTextController::class, 'index'])->name('texts.index');
    Route::post('/teks-beranda', [HomepageTextController::class, 'update'])->name('texts.update');

    // Absensi Kajian
    Route::get('/kajian', [KajianController::class, 'index'])->name('kajian.index');
    Route::post('/kajian', [KajianController::class, 'store'])->name('kajian.store');
    Route::delete('/kajian', [KajianController::class, 'destroy'])->name('kajian.destroy');

    // Kelola Galeri
    Route::get('/galeri', [GalleryController::class, 'index'])->name('galleries.index');
    Route::post('/galeri', [GalleryController::class, 'store'])->name('galleries.store');
    Route::delete('/galeri/{gallery}', [GalleryController::class, 'destroy'])->name('galleries.destroy');

    // Rute untuk Halaman Kas & Infaq
    Route::get('/kas', [KasController::class, 'index'])->name('kas.index');
    Route::get('/kas/export-pdf', [KasController::class, 'exportPdf'])->name('kas.export.pdf');
    Route::post('/kas/iuran', [KasController::class, 'storeIuran'])->name('kas.iuran.store');
    Route::post('/kas/iuran/libur', [KasController::class, 'storeLibur'])->name('kas.iuran.libur');
    Route::delete('/kas/iuran', [KasController::class, 'destroyIuran'])->name('kas.iuran.destroy');
    Route::post('/kas/pengeluaran', [KasController::class, 'storePengeluaran'])->name('kas.pengeluaran.store');
    Route::delete('/kas/pengeluaran/{pengeluaran}', [KasController::class, 'destroyPengeluaran'])->name('kas.pengeluaran.destroy');
});

require __DIR__.'/auth.php';
