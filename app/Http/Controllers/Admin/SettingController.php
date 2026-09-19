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

        return view('admin.settings.index', compact('heroImage', 'socialInstagram', 'socialWhatsapp', 'socialYoutube'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:3072'],
            'social_instagram' => ['nullable', 'url'],
            'social_whatsapp' => ['nullable', 'string', 'max:255'],
            'social_youtube' => ['nullable', 'url'],
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

        return redirect()->route('admin.settings.index')->with('success', 'Foto Hero dan Pengaturan Kontak WhatsApp/Sosmed berhasil diperbarui.');
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
