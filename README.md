# Rohis Darul Muttaqin — Web App

Aplikasi web resmi organisasi Rohis Darul Muttaqin. Dibangun dengan Laravel 13, Tailwind CSS, dan Alpine.js.

## Fitur Utama

**Publik**
- Landing page dengan hero, statistik, pilar organisasi, kegiatan, pengurus, galeri, pengumuman, FAQ
- Halaman detail kegiatan & pengumuman
- Formulir pendaftaran anggota baru + notif WhatsApp otomatis (Fonnte)

**Admin**
- Dashboard dengan ringkasan data
- Kelola pendaftaran, pengurus, kegiatan, pengumuman, galeri, teks beranda, foto hero
- Absensi piket masjid (Senin/Kamis) + kelola anggota
- Absensi kajian mingguan — terintegrasi otomatis dengan kas iuran
- Kas & Infaq — iuran mingguan per anggota, rekap bulanan/tahunan, pengeluaran + struk digital, export PDF
- Notifikasi WhatsApp pendaftar baru via Fonnte API

## Tech Stack

- **Backend**: Laravel 13, PHP 8.3
- **Frontend**: Tailwind CSS, Alpine.js, Lucide Icons
- **Database**: MySQL

## Setup Lokal

```bash
git clone https://github.com/RevanRiswadi/rohis_app.git
cd rohis_app
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
npm run build
php artisan serve
```
