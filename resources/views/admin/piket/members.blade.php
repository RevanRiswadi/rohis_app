<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Jadwal Anggota Piket</h2>
            <a href="{{ route('admin.piket.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg text-sm transition">
                Kembali ke Absensi
            </a>
        </div>
    </x-slot>

    <div class="py-12 max-w-5xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="p-4 mb-6 text-sm text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-lg font-bold flex items-center gap-2">
                <i data-lucide="check-circle-2" class="w-4 h-4 shrink-0"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-500 mb-6 text-sm">Pindahkan jadwal anggota cukup dengan <strong>satu klik</strong> pada tombol hari yang diinginkan, lalu klik Simpan di bawah.</p>
            
            <form action="{{ route('admin.piket.updateMembers') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                    <!-- IKHWAN -->
                    <div>
                        <h3 class="font-black text-emerald-800 border-b-2 border-emerald-100 pb-2 mb-4 text-lg flex items-center gap-2">
                            <i data-lucide="user" class="w-4 h-4 text-blue-500"></i>
                            Ikhwan
                        </h3>
                        <div class="space-y-2">
                            @foreach($ikhwan as $member)
                                <div class="flex items-center justify-between p-2 hover:bg-emerald-50/50 rounded-lg border border-transparent transition">
                                    <span class="font-medium text-gray-700">{{ $member->name }}</span>
                                    
                                    <!-- TOMBOL TOGGLE (Sekali Klik) -->
                                    <div class="flex p-1 space-x-1 bg-gray-100 border border-gray-200 rounded-lg shadow-inner">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="days[{{ $member->id }}]" value="Senin" class="peer sr-only" {{ $member->day == 'Senin' ? 'checked' : '' }}>
                                            <div class="px-4 py-1.5 text-xs font-bold text-gray-400 transition rounded-md peer-checked:bg-blue-600 peer-checked:text-white peer-checked:shadow hover:text-gray-700">Senin</div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="days[{{ $member->id }}]" value="Kamis" class="peer sr-only" {{ $member->day == 'Kamis' ? 'checked' : '' }}>
                                            <div class="px-4 py-1.5 text-xs font-bold text-gray-400 transition rounded-md peer-checked:bg-orange-500 peer-checked:text-white peer-checked:shadow hover:text-gray-700">Kamis</div>
                                        </label>
                                    </div>
                                    
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- AKHWAT -->
                    <div>
                        <h3 class="font-black text-emerald-800 border-b-2 border-emerald-100 pb-2 mb-4 text-lg flex items-center gap-2">
                            <i data-lucide="user" class="w-4 h-4 text-purple-500"></i>
                            Akhwat
                        </h3>
                        <div class="space-y-2">
                            @foreach($akhwat as $member)
                                <div class="flex items-center justify-between p-2 hover:bg-emerald-50/50 rounded-lg border border-transparent transition">
                                    <span class="font-medium text-gray-700">{{ $member->name }}</span>
                                    
                                    <!-- TOMBOL TOGGLE (Sekali Klik) -->
                                    <div class="flex p-1 space-x-1 bg-gray-100 border border-gray-200 rounded-lg shadow-inner">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="days[{{ $member->id }}]" value="Senin" class="peer sr-only" {{ $member->day == 'Senin' ? 'checked' : '' }}>
                                            <div class="px-4 py-1.5 text-xs font-bold text-gray-400 transition rounded-md peer-checked:bg-blue-600 peer-checked:text-white peer-checked:shadow hover:text-gray-700">Senin</div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="days[{{ $member->id }}]" value="Kamis" class="peer sr-only" {{ $member->day == 'Kamis' ? 'checked' : '' }}>
                                            <div class="px-4 py-1.5 text-xs font-bold text-gray-400 transition rounded-md peer-checked:bg-orange-500 peer-checked:text-white peer-checked:shadow hover:text-gray-700">Kamis</div>
                                        </label>
                                    </div>
                                    
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-10 border-t border-gray-100 pt-6 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 px-8 rounded-xl shadow-lg transition transform hover:-translate-y-1">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Simpan Perubahan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>