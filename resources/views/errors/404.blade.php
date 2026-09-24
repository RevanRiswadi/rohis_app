<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — Halaman Tidak Ditemukan | Rohis Darul Muttaqin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css'])
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body class="min-h-screen bg-islamic-pattern text-slate-800 antialiased flex flex-col items-center justify-center px-4">

    <div class="text-center max-w-lg mx-auto space-y-6">

        {{-- Logo --}}
        <div class="flex justify-center mb-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Rohis Darul Muttaqin"
                 class="w-20 h-20 rounded-full object-cover shadow-lg shadow-emerald-600/20 border-4 border-white">
        </div>

        {{-- 404 --}}
        <div>
            <p class="text-[120px] sm:text-[160px] font-black leading-none tracking-tighter text-transparent bg-clip-text bg-gradient-to-br from-emerald-500 to-teal-600 select-none">
                404
            </p>
        </div>

        {{-- Pesan --}}
        <div class="space-y-2">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Halaman Tidak Ditemukan
            </h1>
            <p class="text-sm sm:text-base text-slate-500 leading-relaxed">
                Halaman yang kamu cari tidak ada atau sudah dipindahkan.
                Mungkin terdapat kesalahan ketik di URL?
            </p>
        </div>

        {{-- Kutipan --}}
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/80 px-6 py-4 text-sm text-emerald-800 italic">
            "وَإِذَا سَأَلَكَ عِبَادِي عَنِّي فَإِنِّي قَرِيبٌ"
            <p class="text-xs font-semibold not-italic mt-1 text-emerald-600">
                "Dan apabila hamba-hamba-Ku bertanya tentang Aku, maka sesungguhnya Aku dekat." — QS. Al-Baqarah: 186
            </p>
        </div>

        {{-- Tombol --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
            <a href="{{ url('/') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-md shadow-emerald-600/20 transition hover:bg-emerald-700 hover:-translate-y-0.5">
                <i data-lucide="house" class="h-4 w-4"></i>
                Kembali ke Beranda
            </a>
            <button onclick="history.back()"
               class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-6 py-3 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Halaman Sebelumnya
            </button>
        </div>

        <p class="text-xs text-slate-400 pt-2">
            © {{ date('Y') }} Rohis Darul Muttaqin
        </p>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
