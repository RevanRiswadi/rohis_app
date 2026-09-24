<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $heroImage = Setting::get('hero_image');
        $socialInstagram = Setting::get('social_instagram', 'https://instagram.com/rohis.sekolah');
        $socialWhatsapp = Setting::get('social_whatsapp', 'https://wa.me/6281234567890');
        $socialYoutube = Setting::get('social_youtube', 'https://youtube.com/@rohis.sekolah');

        // Statistik homepage
        $statAnggota = Setting::get('stat_anggota', '');
        $statProgram = Setting::get('stat_program', '');
        $statKajian = Setting::get('stat_kajian', 'Rutin');
        $statUkhuwah = Setting::get('stat_ukhuwah', '100%');
        $statAnggotaLabel = Setting::get('stat_anggota_label', 'Anggota Aktif');
        $statProgramLabel = Setting::get('stat_program_label', 'Program Kegiatan');
        $statKajianLabel = Setting::get('stat_kajian_label', 'Kajian Mingguan');
        $statUkhuwahLabel = Setting::get('stat_ukhuwah_label', 'Ukhuwah');

        // WhatsApp Fonnte
        $fonnteToken = Setting::get('fonnte_token', '');
        $waAdminNumber = Setting::get('wa_admin_number', '');

        return view('admin.settings.index', compact(
            'heroImage', 'socialInstagram', 'socialWhatsapp', 'socialYoutube',
            'statAnggota', 'statProgram', 'statKajian', 'statUkhuwah',
            'statAnggotaLabel', 'statProgramLabel', 'statKajianLabel', 'statUkhuwahLabel',
            'fonnteToken', 'waAdminNumber',
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:3072'],
            'social_instagram' => ['nullable', 'url'],
            'social_whatsapp' => ['nullable', 'string', 'max:255'],
            'social_youtube' => ['nullable', 'url'],
            'stat_anggota' => ['nullable', 'string', 'max:20'],
            'stat_program' => ['nullable', 'string', 'max:20'],
            'stat_kajian' => ['nullable', 'string', 'max:30'],
            'stat_ukhuwah' => ['nullable', 'string', 'max:20'],
            'stat_anggota_label' => ['nullable', 'string', 'max:40'],
            'stat_program_label' => ['nullable', 'string', 'max:40'],
            'stat_kajian_label' => ['nullable', 'string', 'max:40'],
            'stat_ukhuwah_label' => ['nullable', 'string', 'max:40'],
            'fonnte_token' => ['nullable', 'string', 'max:255'],
            'wa_admin_number' => ['nullable', 'string', 'max:30'],
        ], [
            'hero_image.image' => 'File harus berupa gambar (JPG, PNG, WEBP).',
            'hero_image.max' => 'Ukuran gambar maksimal 3MB.',
            'social_instagram.url' => 'URL Instagram harus berupa link valid.',
            'social_youtube.url' => 'URL YouTube harus berupa link valid.',
        ]);

        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            $tempPath = $file->getRealPath();

            if (! is_file($tempPath) || @getimagesize($tempPath) === false) {
                return back()->withErrors([
                    'hero_image' => 'File yang dipilih bukan gambar yang valid. Silakan upload file JPG, PNG, atau WEBP yang benar.',
                ]);
            }

            $oldImage = Setting::get('hero_image');
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }

            $path = $file->store('hero', 'public');
            Setting::set('hero_image', $path);
        }

        if ($request->filled('social_instagram')) {
            Setting::set('social_instagram', $request->input('social_instagram'));
        }

        if ($request->filled('social_whatsapp')) {
            $formattedWa = $this->formatWhatsappUrl($request->input('social_whatsapp'));
            Setting::set('social_whatsapp', $formattedWa);
        }

        if ($request->filled('social_youtube')) {
            Setting::set('social_youtube', $request->input('social_youtube'));
        }

        // Simpan statistik homepage
        Setting::set('stat_anggota', $request->input('stat_anggota', ''));
        Setting::set('stat_program', $request->input('stat_program', ''));
        Setting::set('stat_kajian', $request->input('stat_kajian', 'Rutin'));
        Setting::set('stat_ukhuwah', $request->input('stat_ukhuwah', '100%'));
        Setting::set('stat_anggota_label', $request->input('stat_anggota_label', 'Anggota Aktif'));
        Setting::set('stat_program_label', $request->input('stat_program_label', 'Program Kegiatan'));
        Setting::set('stat_kajian_label', $request->input('stat_kajian_label', 'Kajian Mingguan'));
        Setting::set('stat_ukhuwah_label', $request->input('stat_ukhuwah_label', 'Ukhuwah'));

        // Simpan konfigurasi Fonnte WhatsApp
        Setting::set('fonnte_token', $request->input('fonnte_token', ''));
        Setting::set('wa_admin_number', $request->input('wa_admin_number', ''));

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil disimpan.');
    }

    private function formatWhatsappUrl(?string $input): string
    {
        if (blank($input)) {
            return 'https://wa.me/6281234567890';
        }

        $input = trim($input);

        if (filter_var($input, FILTER_VALIDATE_URL)) {
            return $input;
        }

        if (str_starts_with($input, 'wa.me/')) {
            return 'https://'.$input;
        }

        $clean = preg_replace('/[^0-9]/', '', $input);
        if (str_starts_with($clean, '0')) {
            $clean = preg_replace('/^0/', '62', $clean);
        } elseif (! str_starts_with($clean, '62') && strlen($clean) > 0) {
            $clean = '62'.$clean;
        }

        return $clean ? "https://wa.me/{$clean}" : 'https://wa.me/6281234567890';
    }

    public function destroy()
    {
        $oldImage = Setting::get('hero_image');
        if ($oldImage && Storage::disk('public')->exists($oldImage)) {
            Storage::disk('public')->delete($oldImage);
        }

        Setting::set('hero_image', null);

        return redirect()->route('admin.settings.index')->with('success', 'Foto Hero berhasil dihapus (kembali ke tampilan placeholder).');
    }
}
