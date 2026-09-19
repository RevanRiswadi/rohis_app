<?php

namespace Database\Seeders;

use App\Models\PiketMember;
use Illuminate\Database\Seeder;

class PiketMemberSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // SENIN - IKHWAN
            ['day' => 'Senin', 'gender' => 'Ikhwan', 'names' => ['Ataya', 'Rizki', 'Bilal', 'Revan', 'Hafiz', 'Muhamad Zaidan', 'M. Rafidz Arizki', 'Faridz', 'Ahmad Sodikin P.']],
            // SENIN - AKHWAT
            ['day' => 'Senin', 'gender' => 'Akhwat', 'names' => ['Intan', 'Namira', 'Husna', 'Azmi', 'Salwa', 'Reisya', 'Alivia', 'Asyifa', 'Salwatun', 'Davina Septiani R.', 'Siti Nuraeni', 'Dinda Anugrah P.', 'Raihanah Keemilah S.']],
            // KAMIS - IKHWAN
            ['day' => 'Kamis', 'gender' => 'Ikhwan', 'names' => ['Zaky', 'Safwan', 'Dafi', 'Arkan', 'Zidan Erlangga', 'Muhammad Azril F.', 'M. Kahlil Gibran', 'M. Rafky Nurdiansyah']],
            // KAMIS - AKHWAT
            ['day' => 'Kamis', 'gender' => 'Akhwat', 'names' => ['Dhara', 'Ardilla', 'Radiyya', 'Nazwa', 'Khaira', 'Qowiya', 'Andini', 'Faaiza', 'Anggun', 'Fidelya Aoisora', 'Adis Alyo H.', 'Zazkia Ramadhani', 'Dzahra Maulidya', 'Aisyah Firzana']],
        ];

        foreach ($data as $group) {
            foreach ($group['names'] as $name) {
                PiketMember::create([
                    'name' => $name,
                    'gender' => $group['gender'],
                    'day' => $group['day'],
                ]);
            }
        }
    }
}
