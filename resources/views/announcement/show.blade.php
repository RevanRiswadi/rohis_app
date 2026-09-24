<x-public-layout :title="$announcement->title . ' — Rohis Darul Muttaqin'" :active="'pengumuman'">

    <article class="py-16 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="mb-8 flex items-center gap-2 text-xs font-semibold text-slate-500">
            <a href="{{ route('home') }}" class="hover:text-emerald-700 transition">Beranda</a>
            <x-icon name="chevron-right" class="w-3 h-3" />
            <a href="{{ route('announcement.index') }}" class="hover:text-emerald-700 transition">Pengumuman</a>
            <x-icon name="chevron-right" class="w-3 h-3" />
            <span class="text-slate-800 line-clamp-1">{{ $announcement->title }}</span>
        </nav>

        {{-- Header --}}
        <header class="mb-8 space-y-4">
            <span class="rohis-badge">
                <x-icon name="bell" class="w-3.5 h-3.5 text-emerald-600" />
                Pengumuman
            </span>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900 leading-tight">
                {{ $announcement->title }}
            </h1>
            <p class="text-sm text-slate-500 flex items-center gap-2">
                <x-icon name="calendar" class="w-4 h-4 text-emerald-600" />
                Dipublikasikan {{ $announcement->created_at->translatedFormat('d F Y') }}
            </p>
        </header>

        {{-- Gambar utama --}}
        @if($announcement->image_path && Storage::disk('public')->exists($announcement->image_path))
            <div class="mb-10 overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                <img src="{{ asset('storage/'.$announcement->image_path) }}" alt="{{ $announcement->title }}"
                     class="w-full object-cover max-h-96">
            </div>
        @endif

        {{-- Konten --}}
        <div class="prose prose-slate prose-emerald max-w-none text-slate-700 leading-relaxed">
            {!! $announcement->content !!}
        </div>

        {{-- Footer --}}
        <div class="mt-12 pt-6 border-t border-slate-100 flex items-center justify-between flex-wrap gap-4">
            <a href="{{ route('announcement.index') }}"
               class="inline-flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-emerald-700 transition">
                <x-icon name="arrow-left" class="w-4 h-4" />
                Semua Pengumuman
            </a>
            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-2 text-sm font-bold text-emerald-700 hover:text-emerald-800 transition">
                <x-icon name="home" class="w-4 h-4" />
                Kembali ke Beranda
            </a>
        </div>
    </article>

</x-public-layout>
