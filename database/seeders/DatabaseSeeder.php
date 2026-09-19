<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Officer;
use App\Models\PiketMember;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin Utama
        User::create([
            'name' => 'Admin Rohis',
            'email' => 'admin@rohis.com',
            'password' => bcrypt('password123'),
        ]);

        // 2. Data Pengurus Inti
        $officers = [
            ['name' => 'Ahmad Fauzi', 'position' => 'Ketua Umum'],
            ['name' => 'Siti Aminah', 'position' => 'Wakil Ketua'],
            ['name' => 'Muhammad Rizki', 'position' => 'Sekretaris'],
            ['name' => 'Fatimah Az-Zahra', 'position' => 'Bendahara'],
        ];
        foreach ($officers as $officer) {
            Officer::create($officer);
        }

        // 3. Data FAQ (Tanya Jawab)
        $faqs = [
            [
                'question' => 'Apakah Rohis hanya untuk yang sudah pintar agama?',
                'answer' => 'Tentu saja tidak. Rohis adalah tempat kita belajar bersama dari nol. Tidak ada syarat harus pandai membaca Al-Quran atau paham agama secara mendalam.',
            ],
            [
                'question' => 'Kapan pendaftaran anggota baru dibuka?',
                'answer' => 'Pendaftaran anggota baru dibuka setiap saat melalui website ini. Namun penerimaan resmi biasanya diadakan di awal tahun ajaran baru.',
            ],
        ];
        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
        // 4. Data Anggota Piket Resmi (Senin & Kamis)
        $piketMembers = [
            // ==================== SENIN ====================
            // Ikhwan Senin
            ['name' => 'Ataya', 'gender' => 'Ikhwan', 'day' => 'Senin'],
            ['name' => 'Rizki', 'gender' => 'Ikhwan', 'day' => 'Senin'],
            ['name' => 'Bilal', 'gender' => 'Ikhwan', 'day' => 'Senin'],
            ['name' => 'Revan', 'gender' => 'Ikhwan', 'day' => 'Senin'],
            ['name' => 'Hafiz', 'gender' => 'Ikhwan', 'day' => 'Senin'],
            ['name' => 'Muhamad Zaidan', 'gender' => 'Ikhwan', 'day' => 'Senin'],
            ['name' => 'M. Rafidz Arizki', 'gender' => 'Ikhwan', 'day' => 'Senin'],
            ['name' => 'Faridz', 'gender' => 'Ikhwan', 'day' => 'Senin'],
            ['name' => 'Ahmad Sodikin P.', 'gender' => 'Ikhwan', 'day' => 'Senin'],

            // Akhwat Senin
            ['name' => 'Intan', 'gender' => 'Akhwat', 'day' => 'Senin'],
            ['name' => 'Namira', 'gender' => 'Akhwat', 'day' => 'Senin'],
            ['name' => 'Husna', 'gender' => 'Akhwat', 'day' => 'Senin'],
            ['name' => 'Azmi', 'gender' => 'Akhwat', 'day' => 'Senin'],
            ['name' => 'Salwa', 'gender' => 'Akhwat', 'day' => 'Senin'],
            ['name' => 'Reisya', 'gender' => 'Akhwat', 'day' => 'Senin'],
            ['name' => 'Alivia', 'gender' => 'Akhwat', 'day' => 'Senin'],
            ['name' => 'Asyifa', 'gender' => 'Akhwat', 'day' => 'Senin'],
            ['name' => 'Salwatun', 'gender' => 'Akhwat', 'day' => 'Senin'],
            ['name' => 'Davina Septiani R.', 'gender' => 'Akhwat', 'day' => 'Senin'],
            ['name' => 'Siti Nuraeni', 'gender' => 'Akhwat', 'day' => 'Senin'],
            ['name' => 'Dinda Anugrah P.', 'gender' => 'Akhwat', 'day' => 'Senin'],
            ['name' => 'Raihanah Keemilah S.', 'gender' => 'Akhwat', 'day' => 'Senin'],

            // ==================== KAMIS ====================
            // Ikhwan Kamis
            ['name' => 'Zaky', 'gender' => 'Ikhwan', 'day' => 'Kamis'],
            ['name' => 'Safwan', 'gender' => 'Ikhwan', 'day' => 'Kamis'],
            ['name' => 'Dafi', 'gender' => 'Ikhwan', 'day' => 'Kamis'],
            ['name' => 'Arkan', 'gender' => 'Ikhwan', 'day' => 'Kamis'],
            ['name' => 'Zidan Erlangga', 'gender' => 'Ikhwan', 'day' => 'Kamis'],
            ['name' => 'Muhammad Azril F.', 'gender' => 'Ikhwan', 'day' => 'Kamis'],
            ['name' => 'M. Kahlil Gibran', 'gender' => 'Ikhwan', 'day' => 'Kamis'],
            ['name' => 'M. Rafky Nurdiansyah', 'gender' => 'Ikhwan', 'day' => 'Kamis'],

            // Akhwat Kamis
            ['name' => 'Dhara', 'gender' => 'Akhwat', 'day' => 'Kamis'],
            ['name' => 'Ardilla', 'gender' => 'Akhwat', 'day' => 'Kamis'],
            ['name' => 'Radiyya', 'gender' => 'Akhwat', 'day' => 'Kamis'],
            ['name' => 'Nazwa', 'gender' => 'Akhwat', 'day' => 'Kamis'],
            ['name' => 'Khaira', 'gender' => 'Akhwat', 'day' => 'Kamis'],
            ['name' => 'Qowiya', 'gender' => 'Akhwat', 'day' => 'Kamis'],
            ['name' => 'Andini', 'gender' => 'Akhwat', 'day' => 'Kamis'],
            ['name' => 'Faaiza', 'gender' => 'Akhwat', 'day' => 'Kamis'],
            ['name' => 'Anggun', 'gender' => 'Akhwat', 'day' => 'Kamis'],
            ['name' => 'Fidelya Aoisora', 'gender' => 'Akhwat', 'day' => 'Kamis'],
            ['name' => 'Adis Alyo H.', 'gender' => 'Akhwat', 'day' => 'Kamis'],
            ['name' => 'Zazkia Ramadhani', 'gender' => 'Akhwat', 'day' => 'Kamis'],
            ['name' => 'Dzahra Maulidya', 'gender' => 'Akhwat', 'day' => 'Kamis'],
            ['name' => 'Aisyah Firzana', 'gender' => 'Akhwat', 'day' => 'Kamis'],
        ];

        foreach ($piketMembers as $member) {
            PiketMember::create($member);
        }
        // 5. Data Kegiatan / Program
        Schedule::create([
            'title' => 'Kajian Akbar Mingguan',
            'description' => 'Kajian rutin membahas fiqih sehari-hari dan pembentukan karakter pemuda Islam.',
            'event_date' => now()->addDays(2),
        ]);
    }
}
