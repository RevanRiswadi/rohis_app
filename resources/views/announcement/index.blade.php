<x-public-layout :title="'Pengumuman — Rohis Darul Muttaqin'" :active="'pengumuman'">

    <section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12">
            <span class="rohis-badge">
                <x-icon name="bell" class="w-3.5 h-3.5 text-emerald-600" />
                Info & Pemberitahuan
            </span>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900 mt-3">
                Pengumuman Rohis
            </h1>
            <p class="mt-2 text-sm text-slate-500">Informasi terbaru dari pengurus Rohis Darul Muttaqin.</p>
        </div>

        @if($announcements->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($announcements as $ann)
                    <a href="{{ route('announcement.show', $ann->slug) }}"
                       class="group bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-md hover:border-emerald-300 transition duration-200 flex flex-col">
                        @if($ann->image_path && Storage::disk('public')->exists($ann->image_path))
                            <div class="h-44 overflow-hidden bg-slate-100">
                                <img src="{{ asset('storage/'.$ann->image_path) }}" alt="{{ $ann->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            </div>
                        @else
                            <div class="h-44 bg-gradient-to-br from-emerald-50 to-teal-50 flex items-center justify-center text-emerald-300">
                                <x-icon name="megaphone" class="w-12 h-12 opacity-40" />
                            </div>
                        @endif
                        <div class="p-6 flex flex-col flex-1">
                            <p class="text-[11px] font-bold uppercase tracking-widest text-emerald-700 mb-2">
                                {{ $ann->created_at->translatedFormat('d F Y') }}
                            </p>
                            <h2 class="text-base font-extrabold text-slate-900 group-hover:text-emerald-700 transition leading-snug flex-1">
                                {{ $ann->title }}
                            </h2>
                            <p class="mt-3 text-sm text-slate-500 line-clamp-2 leading-relaxed">
                                {{ strip_tags($ann->content) }}
                            </p>
                            <div class="mt-4 inline-flex items-center gap-1 text-xs font-bold text-emerald-700">
                                Baca selengkapnya
                                <x-icon name="chevron-right" class="w-3.5 h-3.5" />
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $announcements->links() }}
            </div>
        @else
            <div class="flex flex-col items-center gap-4 py-24 text-slate-400">
                <x-icon name="megaphone" class="w-12 h-12 opacity-30" />
                <p class="text-sm font-medium">Belum ada pengumuman yang dipublikasikan.</p>
                <a href="{{ route('home') }}" class="text-sm font-bold text-emerald-700 hover:underline">
                    ← Kembali ke Beranda
                </a>
            </div>
        @endif
    </section>

</x-public-layout>
