<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Teks Beranda</h2>
    </x-slot>

    <div class="py-12 max-w-4xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="p-4 mb-6 text-sm text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-lg font-bold">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-500 mb-8">Ubah teks yang tampil di halaman depan website pada form di bawah ini.</p>
            
            <form action="{{ route('admin.texts.update') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Teks Label Kecil (Atas)</label>
                    <input type="text" name="hero_badge" value="{{ \App\Models\Setting::get('hero_badge', 'Komunitas Rohis Modern') }}" class="w-full rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500" required>
                    <p class="text-xs text-gray-400 mt-1">Contoh: Komunitas Rohis Modern / Ekskul Terfavorit</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Teks Judul Utama (Warna Putih)</label>
                    <textarea name="hero_title_main" rows="2" class="w-full rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500" required>{{ \App\Models\Setting::get('hero_title_main', 'Membentuk Generasi Muda Islam yang') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Teks Judul Sorotan (Warna Kuning)</label>
                    <input type="text" name="hero_title_highlight" value="{{ \App\Models\Setting::get('hero_title_highlight', 'Berakhlak, Cerdas, dan Inklusif') }}" class="w-full rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Teks Deskripsi Panjang</label>
                    <textarea name="hero_description" rows="4" class="w-full rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500" required>{{ \App\Models\Setting::get('hero_description', 'Rohis Darul Muttaqin hadir sebagai wadah kebaikan dan ruang bertumbuh bagi siswa-siswi untuk memperdalam pemahaman agama, mempererat ukhuwah Islamiyah, dan mengembangkan potensi diri dalam suasana yang aman, inspiratif, serta menyenangkan.') }}</textarea>
                </div>

                <hr class="border-gray-100 my-8">
                
                <h3 class="text-lg font-black text-emerald-800 mb-4">📱 Pengaturan WhatsApp</h3>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nomor WA Tujuan (Pengurus / Penerima Notif)</label>
                    <input type="text" name="wa_group_number" value="{{ \App\Models\Setting::get('wa_group_number', '') }}" class="w-full rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: 6281234567890">
                    <p class="text-xs text-gray-400 mt-1">*Awali dengan 62 (tanpa angka 0 dan tanda +). Jika dikosongkan, Anda bisa memilih grup/kontak manual saat tombol diklik.</p>
                </div>
                
                <div class="pt-4 flex justify-end">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition">
                        Simpan Teks Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>