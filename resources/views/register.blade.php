<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Anggota Baru - Rohis Darul Muttaqin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen overflow-x-hidden bg-gradient-to-br from-emerald-50/70 via-slate-50 to-teal-50/40 text-slate-800 antialiased flex flex-col justify-between">
    @php
        $socialLinks = [
            ['label' => 'Instagram', 'url' => $socialInstagram ?? 'https://instagram.com/rohis.sekolah', 'icon' => 'instagram'],
            ['label' => 'WhatsApp', 'url' => $socialWhatsapp ?? 'https://wa.me/6281234567890', 'icon' => 'whatsapp'],
            ['label' => 'YouTube', 'url' => $socialYoutube ?? 'https://youtube.com/@rohis.sekolah', 'icon' => 'youtube'],
        ];
    @endphp

    <div>
        <!-- Sticky Navbar Aligned with App Aesthetic -->
        <header class="sticky top-0 z-50 border-b border-emerald-100/80 bg-white/85 backdrop-blur-xl shadow-sm">
            <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Rohis Darul Muttaqin" class="h-12 w-12 rounded-full object-cover shadow-md shadow-emerald-600/25 transition duration-300 group-hover:scale-105">
                    <div class="flex flex-col">
                        <span class="text-xl font-black leading-none tracking-tight text-slate-900">Rohis Darul Muttaqin</span>
                        <span class="mt-1 text-[10px] font-bold uppercase tracking-[0.22em] text-emerald-700">Organisasi Kerohanian Islam</span>
                    </div>
                </a>

                <nav class="hidden items-center space-x-8 text-[15px] font-semibold text-slate-600 md:flex">
                    <a href="{{ route('home') }}" class="transition duration-200 hover:text-emerald-700">Beranda</a>
                    <a href="{{ route('home') }}#kegiatan" class="transition duration-200 hover:text-emerald-700">Kegiatan Utama</a>
                    <a href="{{ route('officer.index') }}" class="transition duration-200 hover:text-emerald-700">Pengurus</a>
                    <a href="{{ route('register.create') }}" class="text-emerald-700 font-extrabold">Pendaftaran</a>
                </nav>

                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-5 py-2.5 text-xs font-black tracking-wide text-emerald-800 transition duration-300 hover:bg-emerald-100">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </header>

        <main>
            <!-- Hero Header Section -->
            <section class="relative mx-auto max-w-7xl px-4 pt-12 pb-6 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto space-y-4">
                    <span class="inline-flex items-center gap-2 rounded-full border border-emerald-200/80 bg-emerald-50/90 px-4 py-2 text-xs font-extrabold uppercase tracking-[0.2em] text-emerald-800 shadow-sm">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Bergabung Bersama Kami
                    </span>
                    <h1 class="text-3xl font-black tracking-tight text-slate-900 sm:text-5xl">
                        Formulir Pendaftaran Anggota Baru
                    </h1>
                    <p class="text-base sm:text-lg font-medium text-slate-600 leading-relaxed">
                        Mari menjadi bagian dari keluarga Rohis Sekolah. Isi formulir pendaftaran di bawah ini untuk memulai langkah kebaikanmu bersama kami.
                    </p>
                </div>
            </section>

            <!-- Registration Form Section -->
            <section class="mx-auto max-w-4xl px-4 pb-20 pt-6 sm:px-6 lg:px-8">
                @if(session('success'))
                    <div class="mb-8 rounded-2xl border-2 border-emerald-200 bg-emerald-50 p-6 text-center text-emerald-900 shadow-sm">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h3 class="text-xl font-black text-emerald-900">Pendaftaran Berhasil!</h3>
                        <p class="mt-1 text-base font-semibold text-emerald-700">{{ session('success') }}</p>
                        <div class="mt-4">
                            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-2.5 text-sm font-bold text-white shadow-md transition hover:bg-emerald-700">
                                Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-8 rounded-2xl border-2 border-red-200 bg-red-50 p-5 text-center text-lg font-bold text-red-700 shadow-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-8 rounded-2xl border-2 border-red-200 bg-red-50 p-5 text-left shadow-sm">
                        <p class="text-base font-extrabold text-red-700">Pendaftaran belum berhasil. Silakan periksa kolom berikut:</p>
                        <ul class="mt-3 list-disc space-y-1 pl-5 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="rounded-[2.5rem] border border-emerald-100 bg-white p-8 shadow-[0_25px_60px_rgba(15,118,110,0.07)] md:p-12">
                    <form action="{{ route('register.store') }}" method="POST" class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        @csrf
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-bold text-slate-800">Nama Lengkap</label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Masukkan nama lengkap Anda" class="w-full rounded-2xl border border-slate-200 bg-slate-50/80 px-5 py-3.5 font-medium text-slate-800 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 @error('full_name') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror" required>
                            @error('full_name')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-bold text-slate-800">NISN</label>
                            <input type="text" name="nisn" value="{{ old('nisn') }}" placeholder="Contoh: 0051234567" class="w-full rounded-2xl border border-slate-200 bg-slate-50/80 px-5 py-3.5 font-medium text-slate-800 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 @error('nisn') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror" required>
                            @error('nisn')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-bold text-slate-800">No. WhatsApp</label>
                            <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number') }}" placeholder="Contoh: 081234567890" class="w-full rounded-2xl border border-slate-200 bg-slate-50/80 px-5 py-3.5 font-medium text-slate-800 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 @error('whatsapp_number') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror" required>
                            @error('whatsapp_number')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-bold text-slate-800">Kelas</label>
                            <select name="class" class="w-full rounded-2xl border border-slate-200 bg-slate-50/80 px-5 py-3.5 font-medium text-slate-800 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 cursor-pointer @error('class') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror" required>
                                <option value="" disabled {{ old('class') ? '' : 'selected' }}>-- Pilih Kelas --</option>
                                <option value="X" {{ old('class') == 'X' ? 'selected' : '' }}>X (Sepuluh)</option>
                                <option value="XI" {{ old('class') == 'XI' ? 'selected' : '' }}>XI (Sebelas)</option>
                                <option value="XII" {{ old('class') == 'XII' ? 'selected' : '' }}>XII (Dua Belas)</option>
                            </select>
                            @error('class')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-bold text-slate-800">Jurusan</label>
                            <select name="major" class="w-full rounded-2xl border border-slate-200 bg-slate-50/80 px-5 py-3.5 font-medium text-slate-800 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 cursor-pointer @error('major') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror" required>
                                <option value="" disabled {{ old('major') ? '' : 'selected' }}>-- Pilih Jurusan --</option>
                                <option value="MIPA" {{ old('major') == 'MIPA' ? 'selected' : '' }}>MIPA / IPA</option>
                                <option value="IPS" {{ old('major') == 'IPS' ? 'selected' : '' }}>IPS</option>
                                <option value="PPLG" {{ old('major') == 'PPLG' ? 'selected' : '' }}>PPLG (RPL)</option>
                                <option value="Animasi" {{ old('major') == 'Animasi' ? 'selected' : '' }}>Animasi</option>
                                <option value="TJKT" {{ old('major') == 'TJKT' ? 'selected' : '' }}>TJKT (TKJ)</option>
                                <option value="DKV" {{ old('major') == 'DKV' ? 'selected' : '' }}>DKV</option>
                                <option value="Lainnya" {{ old('major') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('major')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-bold text-slate-800">Divisi Pilihan</label>
                            <select name="preferred_division" class="w-full rounded-2xl border border-slate-200 bg-slate-50/80 px-5 py-3.5 font-medium text-slate-800 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 cursor-pointer @error('preferred_division') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror" required>
                                <option value="" disabled {{ old('preferred_division') ? '' : 'selected' }}>-- Pilih Divisi yang Diminati --</option>
                                <option value="Dakwah & Syiar" {{ old('preferred_division') == 'Dakwah & Syiar' ? 'selected' : '' }}>Dakwah & Syiar (Kajian, Mabit, PHBI)</option>
                                <option value="Kaderisasi & Mentoring" {{ old('preferred_division') == 'Kaderisasi & Mentoring' ? 'selected' : '' }}>Kaderisasi & Mentoring (Bina Anggota)</option>
                                <option value="Humas & Hubungan Luar" {{ old('preferred_division') == 'Humas & Hubungan Luar' ? 'selected' : '' }}>Humas & Hubungan Luar (Jaringan)</option>
                                <option value="Multimedia & IT" {{ old('preferred_division') == 'Multimedia & IT' ? 'selected' : '' }}>Multimedia & IT (Desain, Medsos)</option>
                                <option value="Seni Islami" {{ old('preferred_division') == 'Seni Islami' ? 'selected' : '' }}>Seni Islami (Nasyid, Hadroh, MTQ)</option>
                                <option value="Dana & Usaha (Danus)" {{ old('preferred_division') == 'Dana & Usaha (Danus)' ? 'selected' : '' }}>Dana & Usaha (Kewirausahaan)</option>
                            </select>
                            @error('preferred_division')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-bold text-slate-800">Alasan Bergabung</label>
                            <textarea name="reason" rows="4" placeholder="Ceritakan motivasi atau alasan kamu ingin bergabung dengan Rohis Sekolah..." class="w-full rounded-2xl border border-slate-200 bg-slate-50/80 px-5 py-3.5 font-medium text-slate-800 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 @error('reason') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror" required>{{ old('reason') }}</textarea>
                            @error('reason')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-2 md:col-span-2">
                            <button type="submit" class="w-full rounded-2xl bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-600 px-6 py-4 text-base font-extrabold text-white shadow-xl shadow-emerald-600/25 transition duration-300 hover:-translate-y-0.5 hover:from-emerald-700 hover:to-teal-700 active:translate-y-0">
                                Kirim Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <!-- Footer Aligned with Site Theme -->
    <footer class="border-t border-emerald-900/30 bg-slate-950 py-12 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-8 text-center md:flex-row md:items-center md:justify-between md:text-left">
                <div>
                    <div class="flex items-center justify-center gap-3 md:justify-start">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Rohis Darul Muttaqin" class="h-12 w-12 rounded-full object-cover shadow-md shadow-emerald-600/25">
                        <div>
                            <p class="text-xl font-black text-white">Rohis Darul Muttaqin</p>
                            <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-emerald-400">Organisasi Kerohanian Islam</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-center gap-4 md:items-end">
                    <div class="flex flex-wrap items-center justify-center gap-2.5 md:justify-end">
                        @foreach($socialLinks as $social)
                            @php
                                $footerSocialClass = match($social['icon']) {
                                    'instagram' => 'hover:border-pink-500/70 hover:bg-gradient-to-tr hover:from-[#f09433] hover:via-[#dc2743] hover:to-[#bc1888] hover:text-white hover:shadow-md hover:shadow-pink-500/20 active:from-[#e08323] active:via-[#cc1733] active:to-[#ac0878] active:scale-95',
                                    'whatsapp' => 'hover:border-emerald-400/70 hover:bg-[#25D366] hover:text-white hover:shadow-md hover:shadow-[#25D366]/25 active:bg-[#128C7E] active:scale-95',
                                    'youtube' => 'hover:border-red-500/70 hover:bg-[#FF0000] hover:text-white hover:shadow-md hover:shadow-red-500/25 active:bg-[#cc0000] active:scale-95',
                                    default => 'hover:border-emerald-400/50 hover:bg-emerald-800/40 hover:text-white active:bg-emerald-700/60 active:scale-95',
                                };
                            @endphp
                            <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-bold text-slate-200 transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0 {{ $footerSocialClass }}" aria-label="{{ $social['label'] }}">
                                @if($social['icon'] === 'instagram')
                                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5Zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7Zm5 3.25A5.75 5.75 0 1 1 6.25 13 5.75 5.75 0 0 1 12 7.25Zm0 2A3.75 3.75 0 1 0 15.75 13 3.75 3.75 0 0 0 12 9.25Zm5.5-3.2a1.2 1.2 0 1 1-1.2-1.2 1.2 1.2 0 0 1 1.2 1.2Z"/></svg>
                                @elseif($social['icon'] === 'whatsapp')
                                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12.04 2C6.59 2 2.18 6.38 2.18 11.81c0 2.05.61 4.04 1.66 5.76L2 22l4.6-1.53a9.8 9.8 0 0 0 5.44 1.73h.01c5.45 0 9.86-4.38 9.86-9.81S17.49 2 12.04 2Zm5.55 13.55c-.24.66-1.42 1.22-1.94 1.29-.5.07-1.13.09-3.68-.77-3.12-1.38-5.12-4.94-5.27-5.17-.15-.23-1.25-1.67-1.25-3.17 0-1.5.77-2.24 1.05-2.54.28-.3.6-.38.8-.38h.57c.18 0 .43.01.66.5.3.64.97 2.2.99 2.38.02.17-.14.41-.27.55-.16.15-.32.35-.46.48-.28.29-.58.63-.4 1.2.18.57 1.03 1.89 2.2 3.06 1.54 1.38 2.8 1.81 3.38 2.01.57.2.91.17 1.24-.1.45-.38 1.09-.95 1.39-1.28.3-.33.61-.28.98-.17.37.11 2.34 1.1 2.75 1.3.4.2.67.3.77.47.1.17.1.98-.13 1.64Z"/></svg>
                                @elseif($social['icon'] === 'youtube')
                                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M23.5 6.2a3.06 3.06 0 0 0-2.15-2.17C19.46 3.5 12 3.5 12 3.5s-7.46 0-9.35.53A3.06 3.06 0 0 0 .5 6.2 31.31 31.31 0 0 0 0 12a31.31 31.31 0 0 0 .5 5.8 3.06 3.06 0 0 0 2.15 2.17c1.89.53 9.35.53 9.35.53s7.46 0 9.35-.53a3.06 3.06 0 0 0 2.15-2.17A31.31 31.31 0 0 0 24 12a31.31 31.31 0 0 0-.5-5.8ZM9.75 15.5v-7l6.5 3.5-6.5 3.5Z"/></svg>
                                @else
                                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M16.5 1.5c1.9 0 3.5 1.6 3.5 3.5v13c0 1.9-1.6 3.5-3.5 3.5h-9c-1.9 0-3.5-1.6-3.5-3.5V5c0-1.9 1.6-3.5 3.5-3.5h9Zm-4.5 5.2a4.8 4.8 0 1 0 0 9.6 4.8 4.8 0 0 0 0-9.6Zm0 2.2a2.6 2.6 0 1 1 0 5.2 2.6 2.6 0 0 1 0-5.2Zm5.1-3.1a1.1 1.1 0 1 1-2.2 0 1.1 1.1 0 0 1 2.2 0Z"/></svg>
                                @endif
                                <span>{{ $social['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                    <p class="text-xs font-medium text-slate-400">© {{ date('Y') }} Rohis Darul Muttaqin. Hak Cipta Dilindungi.</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
