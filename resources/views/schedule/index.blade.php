<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Semua Kegiatan - Rohis Darul Muttaqin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-white text-gray-800 antialiased">
    <header class="border-b border-gray-100 bg-white sticky top-0 z-40 backdrop-blur-md">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Rohis Darul Muttaqin" class="w-10 h-10 rounded-full object-cover shadow-sm">
                <div>
                    <div class="text-lg font-extrabold text-gray-900">Rohis Darul Muttaqin</div>
                </div>
            </a>

            <a href="{{ route('home') }}" class="bg-[#059669] text-white px-5 py-2.5 rounded-full text-sm font-bold hover:bg-[#047857] transition">
                Kembali ke Beranda
            </a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="mb-12 text-center">
            <p class="text-sm font-bold uppercase tracking-[0.18em] text-[#059669] mb-3">Dokumentasi</p>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900">Semua Kegiatan Rohis</h1>
        </div>

        @if($schedules->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                @foreach($schedules as $schedule)
                    <article class="group bg-white overflow-hidden rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-2xl transition duration-300">
                        <div class="relative overflow-hidden">
                            @if($schedule->image_path && Storage::disk('public')->exists($schedule->image_path))
                                <img src="{{ asset('storage/' . $schedule->image_path) }}" alt="{{ $schedule->title }}" class="w-full h-60 object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-60 bg-gradient-to-br from-emerald-100 via-emerald-50 to-slate-200 flex items-center justify-center text-gray-600 font-extrabold uppercase tracking-[0.2em] text-xs">
                                    Dokumentasi
                                </div>
                            @endif
                            <div class="absolute inset-x-0 top-0 flex justify-between items-center p-4">
                                <span class="bg-white/80 backdrop-blur-sm text-[#059669] text-[10px] font-extrabold uppercase tracking-[0.18em] px-2.5 py-1.5 rounded-full">
                                    {{ ucfirst($schedule->status) }}
                                </span>
                                <span class="bg-slate-900/70 text-white text-[10px] font-semibold px-2.5 py-1.5 rounded-full">
                                    {{ $schedule->event_date ? $schedule->event_date->format('d M Y') : '-' }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <h2 class="text-2xl font-extrabold text-gray-900 mb-3 leading-tight">{{ $schedule->title }}</h2>
                            <p class="text-gray-500 font-medium leading-relaxed mb-5">{{ Str::limit($schedule->description, 150) }}</p>

                            <div class="space-y-2 text-sm text-gray-600 border-t border-gray-100 pt-4">
                                <p><strong>Lokasi:</strong> {{ $schedule->location }}</p>
                                @if($schedule->speaker)
                                    <p><strong>Pembicara:</strong> {{ $schedule->speaker }}</p>
                                @endif
                            </div>

                            <div class="mt-5">
                                <a href="{{ route('schedule.show', $schedule) }}" class="inline-flex items-center justify-center w-full rounded-xl bg-[#059669] px-4 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-[#047857]">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-[2rem] border-2 border-dashed border-gray-300 bg-gray-50 p-12 text-center text-gray-500 font-medium">
                Belum ada kegiatan yang ditambahkan.
            </div>
        @endif
    </main>
</body>
</html>
