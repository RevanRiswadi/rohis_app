<x-public-layout :title="'Pendaftaran Anggota Baru - Rohis Darul Muttaqin'" :active="'daftar'">

    <!-- HEADER / HERO -->
    <section class="relative max-w-7xl mx-auto px-4 pt-12 pb-8 sm:px-6 lg:px-8 text-center">
        <div class="max-w-2xl mx-auto space-y-4">
            <span class="rohis-badge">
                <x-icon name="user-plus" class="w-3.5 h-3.5 text-emerald-600" />
                Penerimaan Anggota Baru
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-slate-900">
                Formulir Pendaftaran Siswa
            </h1>
            <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                Mari menjadi bagian dari keluarga besar Rohis Darul Muttaqin. Silakan lengkapi biodata singkat di bawah ini untuk memulai langkah kebaikan bersama kami.
            </p>
        </div>
    </section>

    <!-- FORM SECTION -->
    <section class="max-w-3xl mx-auto px-4 pb-20 sm:px-6 lg:px-8">
        <!-- Success Alert -->
        @if(session('success'))
            <div class="mb-8 rounded-2xl border border-emerald-200 bg-emerald-50/90 p-6 text-center text-emerald-900 shadow-sm animate-fade-up">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-600 text-white mb-3 shadow-sm">
                    <x-icon name="check" class="w-6 h-6" />
                </div>
                <h3 class="text-lg font-black text-slate-900">Alhamdulillah, Pendaftaran Berhasil Dikirim!</h3>
                <p class="mt-1.5 text-sm font-medium text-emerald-800 leading-relaxed">{{ session('success') }}</p>
                <div class="mt-5 flex items-center justify-center gap-3">
                    <a href="{{ route('home') }}" class="cta-secondary text-xs">
                        <x-icon name="home" class="w-4 h-4" />
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>
            </div>
        @endif

        <!-- Error Alert -->
        @if(session('error'))
            <div class="mb-8 rounded-2xl border border-red-200 bg-red-50 p-5 text-sm font-bold text-red-700 shadow-xs flex items-center gap-3">
                <x-icon name="info" class="w-5 h-5 shrink-0 text-red-600" />
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-8 rounded-2xl border border-red-200 bg-red-50/90 p-5 text-left shadow-xs">
                <div class="flex items-center gap-2 text-sm font-extrabold text-red-800">
                    <x-icon name="info" class="w-4 h-4 text-red-600" />
                    <span>Mohon periksa kolom yang masih belum sesuai:</span>
                </div>
                <ul class="mt-2.5 list-disc space-y-1 pl-5 text-xs font-medium text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-10 shadow-sm">
            <form action="{{ route('register.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Contoh: Muhammad Fatih" class="form-input @error('full_name') border-red-300 focus:border-red-500 @enderror" required>
                    </div>
                    @error('full_name')
                        <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NISN & WhatsApp (Grid 2 Kolom) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            NISN <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nisn" value="{{ old('nisn') }}" placeholder="Contoh: 0051234567" class="form-input @error('nisn') border-red-300 focus:border-red-500 @enderror" required>
                        @error('nisn')
                            <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Nomor WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number') }}" placeholder="Contoh: 081234567890" class="form-input @error('whatsapp_number') border-red-300 focus:border-red-500 @enderror" required>
                        <span class="text-[11px] text-slate-400 mt-1 block">Pastikan nomor aktif untuk undangan grup koordinasi.</span>
                        @error('whatsapp_number')
                            <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Kelas & Jurusan (Grid 2 Kolom) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Tingkat Kelas <span class="text-red-500">*</span>
                        </label>
                        <select name="class" class="form-input cursor-pointer @error('class') border-red-300 focus:border-red-500 @enderror" required>
                            <option value="" disabled {{ old('class') ? '' : 'selected' }}>-- Pilih Tingkat Kelas --</option>
                            <option value="X" {{ old('class') == 'X' ? 'selected' : '' }}>X (Sepuluh)</option>
                            <option value="XI" {{ old('class') == 'XI' ? 'selected' : '' }}>XI (Sebelas)</option>
                            <option value="XII" {{ old('class') == 'XII' ? 'selected' : '' }}>XII (Dua Belas)</option>
                        </select>
                        @error('class')
                            <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Jurusan / Peminatan <span class="text-red-500">*</span>
                        </label>
                        <select name="major" class="form-input cursor-pointer @error('major') border-red-300 focus:border-red-500 @enderror" required>
                            <option value="" disabled {{ old('major') ? '' : 'selected' }}>-- Pilih Jurusan --</option>
                            <option value="MIPA" {{ old('major') == 'MIPA' ? 'selected' : '' }}>MIPA / IPA</option>
                            <option value="IPS" {{ old('major') == 'IPS' ? 'selected' : '' }}>IPS</option>
                            <option value="PPLG" {{ old('major') == 'PPLG' ? 'selected' : '' }}>PPLG (Rekayasa Perangkat Lunak)</option>
                            <option value="TJKT" {{ old('major') == 'TJKT' ? 'selected' : '' }}>TJKT (Teknik Jaringan Komputer & Telekomunikasi)</option>
                            <option value="DKV" {{ old('major') == 'DKV' ? 'selected' : '' }}>DKV (Desain Komunikasi Visual)</option>
                            <option value="Animasi" {{ old('major') == 'Animasi' ? 'selected' : '' }}>Animasi</option>
                            <option value="Lainnya" {{ old('major') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('major')
                            <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Divisi Pilihan -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Pilihan Minat Divisi <span class="text-red-500">*</span>
                    </label>
                    <select name="preferred_division" class="form-input cursor-pointer @error('preferred_division') border-red-300 focus:border-red-500 @enderror" required>
                        <option value="" disabled {{ old('preferred_division') ? '' : 'selected' }}>-- Pilih Divisi yang Paling Diminati --</option>
                        <option value="Dakwah & Syiar" {{ old('preferred_division') == 'Dakwah & Syiar' ? 'selected' : '' }}>Dakwah & Syiar (Kajian, PHBI, Kultum)</option>
                        <option value="Kaderisasi & Mentoring" {{ old('preferred_division') == 'Kaderisasi & Mentoring' ? 'selected' : '' }}>Kaderisasi & Mentoring (Pemberdayaan & Bimbingan Anggota)</option>
                        <option value="Humas & Hubungan Luar" {{ old('preferred_division') == 'Humas & Hubungan Luar' ? 'selected' : '' }}>Humas & Publikasi (Komunikasi, Silaturahmi Eksternal)</option>
                        <option value="Multimedia & IT" {{ old('preferred_division') == 'Multimedia & IT' ? 'selected' : '' }}>Multimedia & IT (Poster Dakwah, Video, Pengelolaan Website)</option>
                        <option value="Seni Islami" {{ old('preferred_division') == 'Seni Islami' ? 'selected' : '' }}>Seni Islami (Hadroh, Nasyid, Kaligrafi, MTQ)</option>
                        <option value="Dana & Usaha (Danus)" {{ old('preferred_division') == 'Dana & Usaha (Danus)' ? 'selected' : '' }}>Dana & Usaha (Kewirausahaan Mandiri & Bazar)</option>
                    </select>
                    @error('preferred_division')
                        <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alasan Bergabung -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Alasan & Harapan Bergabung <span class="text-red-500">*</span>
                    </label>
                    <textarea name="reason" rows="4" placeholder="Ceritakan motivasi atau hal yang ingin kamu pelajari bersama Rohis..." class="form-textarea @error('reason') border-red-300 focus:border-red-500 @enderror" required>{{ old('reason') }}</textarea>
                    @error('reason')
                        <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="cta-primary w-full py-4 text-base font-extrabold justify-center shadow-md">
                        <x-icon name="user-plus" class="w-5 h-5" />
                        <span>Kirim Pendaftaran Anggota Baru</span>
                    </button>
                    <p class="text-[11px] text-slate-400 text-center mt-3">
                        Dengan menekan tombol di atas, data yang kamu kirimkan akan diteruskan ke tim kepengurusan Rohis Darul Muttaqin secara aman.
                    </p>
                </div>
            </form>
        </div>

        <!-- Help Info Box -->
        <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-5 text-center flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3 text-left">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-700 shrink-0">
                    <x-icon name="whatsapp" class="w-5 h-5" />
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wide text-slate-900">Kendala Pendaftaran?</h4>
                    <p class="text-xs text-slate-500">Hubungi pengurus untuk konfirmasi atau pertanyaan teknis.</p>
                </div>
            </div>
            @if(isset($socialWhatsapp) && filled($socialWhatsapp))
                <a href="{{ $socialWhatsapp }}" target="_blank" rel="noopener noreferrer" class="cta-secondary text-xs shrink-0">
                    <x-icon name="whatsapp" class="w-4 h-4 text-emerald-600" />
                    <span>Hubungi WhatsApp Pengurus</span>
                </a>
            @endif
        </div>
    </section>

</x-public-layout>
