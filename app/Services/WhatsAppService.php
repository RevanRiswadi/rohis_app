<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private const FONNTE_URL = 'https://api.fonnte.com/send';

    /**
     * Kirim pesan WhatsApp via Fonnte API.
     * Gagal secara diam-diam (tidak throw exception) agar pendaftaran tetap berjalan.
     */
    public function send(string $to, string $message): bool
    {
        $token = Setting::get('fonnte_token');

        if (blank($token)) {
            Log::warning('WhatsAppService: fonnte_token belum dikonfigurasi di settings.');

            return false;
        }

        $to = $this->normalizeNumber($to);

        try {
            $response = Http::timeout(10)
                ->withHeaders(['Authorization' => $token])
                ->post(self::FONNTE_URL, [
                    'target' => $to,
                    'message' => $message,
                    'countryCode' => '62',
                ]);

            if ($response->failed()) {
                Log::warning('WhatsAppService: Gagal kirim WA.', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return false;
            }

            Log::info('WhatsAppService: Pesan terkirim ke '.$to);

            return true;
        } catch (\Throwable $e) {
            Log::error('WhatsAppService: Exception — '.$e->getMessage());

            return false;
        }
    }

    /**
     * Kirim notifikasi pendaftar baru ke nomor admin.
     */
    public function notifyNewRegistration(
        string $fullName,
        string $class,
        string $major,
        string $preferredDivision,
        string $whatsappNumber,
    ): bool {
        $adminNumber = Setting::get('wa_admin_number');

        if (blank($adminNumber)) {
            return false;
        }

        $message = "🔔 *Pendaftar Baru Rohis!*\n\n"
            ."Nama     : {$fullName}\n"
            ."Kelas    : {$class}\n"
            ."Jurusan  : {$major}\n"
            ."Divisi   : {$preferredDivision}\n"
            ."No. WA   : {$whatsappNumber}\n\n"
            ."Cek & proses di dashboard admin:\n"
            .route('admin.registrations.index');

        return $this->send($adminNumber, $message);
    }

    /**
     * Normalisasi nomor: 08xx → 628xx, +628xx → 628xx
     */
    private function normalizeNumber(string $number): string
    {
        $clean = preg_replace('/[^0-9]/', '', $number);

        if (str_starts_with($clean, '0')) {
            return '62'.substr($clean, 1);
        }

        if (str_starts_with($clean, '62')) {
            return $clean;
        }

        return '62'.$clean;
    }
}
