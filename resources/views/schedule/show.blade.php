<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $schedule->title }} - Rohis Darul Muttaqin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
    <header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/80 backdrop-blur-xl">
        <div class="mx-auto flex h-20 max-w-6xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Rohis Darul Muttaqin" class="h-11 w-11 rounded-full object-cover shadow-lg shadow-emerald-600/20">
                <div>
                    <div class="text-lg font-extrabold tracking-tight text-slate-900">Rohis Darul Muttaqin</div>
                </div>
            </a>

            <a href="{{ route('home') }}" class="inline-flex items-center rounded-full bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-700">
                Kembali ke Beranda
            </a>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid items-start gap-10 lg:grid-cols-2">
            <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-3 shadow-[0_30px_80px_rgba(15,23,42,0.08)]">
                @if($schedule->image_path && Storage::disk('public')->exists($schedule->image_path))
                    <img src="{{ asset('storage/' . $schedule->image_path) }}" alt="{{ $schedule->title }}" class="h-[520px] w-full rounded-[1.5rem] object-cover">
                @else
                    <div class="flex h-[520px] w-full items-center justify-center rounded-[1.5rem] bg-gradient-to-br from-emerald-100 via-emerald-50 to-slate-200 text-xs font-extrabold uppercase tracking-[0.2em] text-slate-600">
                        Dokumentasi Kegiatan
                    </div>
                @endif
            </div>

            <div>
                <div class="mb-5 flex flex-wrap items-center gap-3">
                    <span class="rounded-full bg-emerald-100 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-[0.18em] text-emerald-700">
                        {{ ucfirst($schedule->status) }}
                    </span>
                    <span class="text-sm font-medium text-slate-500">
                        {{ $schedule->event_date ? $schedule->event_date->format('d M Y') : '-' }}
                    </span>
                </div>

                <h1 class="mb-6 text-4xl font-extrabold leading-tight tracking-tight text-slate-900 md:text-5xl">
                    {{ $schedule->title }}
                </h1>

                <div class="space-y-4 text-base leading-relaxed text-slate-600">
                    <p><strong class="font-bold text-slate-900">Lokasi:</strong> {{ $schedule->location }}</p>
                    @if($schedule->speaker)
                        <p><strong class="font-bold text-slate-900">Pembicara:</strong> {{ $schedule->speaker }}</p>
                    @endif
                    @if($schedule->event_date)
                        <p><strong class="font-bold text-slate-900">Tanggal:</strong> {{ $schedule->event_date->format('d M Y, H:i') }}</p>
                    @endif
                </div>

                <div class="mt-8 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="mb-3 text-lg font-extrabold text-slate-900">Deskripsi Kegiatan</h2>
                    <p class="whitespace-pre-line leading-relaxed text-slate-600">{{ $schedule->description }}</p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
