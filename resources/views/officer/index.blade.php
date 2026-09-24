<x-public-layout :title="'Struktur Pengurus - Rohis Darul Muttaqin'" :active="'pengurus'">

    <!-- HEADER / HERO -->
    <section class="relative max-w-7xl mx-auto px-4 pt-12 pb-8 sm:px-6 lg:px-8 text-center">
        <div class="max-w-3xl mx-auto space-y-4">
            <span class="rohis-badge">
                <x-icon name="users" class="w-3.5 h-3.5 text-emerald-600" />
                Struktur Organisasi
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-slate-900">
                Susunan Pengurus Rohis Darul Muttaqin
            </h1>
            <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                Mengenal lebih dekat rekan-rekan penggerak dakwah, pembinaan, dan aktivitas keislaman di lingkungan sekolah.
            </p>
        </div>
    </section>

    <!-- OFFICERS GRID -->
    <section class="max-w-7xl mx-auto px-4 pb-20 sm:px-6 lg:px-8">
        @if(isset($officers) && $officers->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($officers as $officer)
                    @php
                        $photo = $officer->photo_path ?? $officer->image_path;
                        $hasPhoto = filled($photo) && Storage::disk('public')->exists($photo);
                    @endphp
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 text-center shadow-xs hover:border-emerald-300 hover:shadow-md transition duration-200 group flex flex-col justify-between">
                        <div>
                            <!-- Photo Avatar -->
                            <div class="relative w-28 h-28 mx-auto mb-4 overflow-hidden rounded-full border-2 border-emerald-100 p-1 bg-emerald-50/50">
                                @if($hasPhoto)
                                    <img src="{{ asset('storage/' . $photo) }}" alt="{{ $officer->name }}" class="object-cover w-full h-full rounded-full group-hover:scale-105 transition duration-200">
                                @else
                                    <div class="flex items-center justify-center w-full h-full rounded-full bg-emerald-100 text-emerald-800 font-black text-2xl uppercase">
                                        {{ strtoupper(substr($officer->name, 0, 2)) }}
                                    </div>
                                @endif
                            </div>

                            <h3 class="text-lg font-black text-slate-900 leading-snug group-hover:text-emerald-700 transition">
                                {{ $officer->name }}
                            </h3>
                            <div class="mt-2">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold text-emerald-800 bg-emerald-50 border border-emerald-100 uppercase tracking-wide">
                                    {{ $officer->position }}
                                </span>
                            </div>
                        </div>

                        @if($officer->class_major)
                            <div class="mt-4 pt-3 border-t border-slate-100 text-xs font-semibold text-slate-500">
                                {{ $officer->class_major }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="rounded-3xl border border-slate-200 bg-white p-12 text-center max-w-md mx-auto shadow-xs">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 mx-auto mb-4">
                    <x-icon name="users" class="w-7 h-7" />
                </div>
                <h3 class="text-lg font-black text-slate-900">Belum Ada Data Pengurus</h3>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Daftar susunan kepengurusan saat ini sedang dalam proses pembaharuan oleh administrator.
                </p>
                <div class="mt-5">
                    <a href="{{ route('home') }}" class="cta-secondary text-xs">
                        <x-icon name="home" class="w-4 h-4" />
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>
            </div>
        @endif
    </section>

</x-public-layout>