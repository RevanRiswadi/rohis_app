<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ceklis Piket Masjid</h2>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.piket.members') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-sm shadow-sm transition">
                    <i data-lucide="settings-2" class="w-4 h-4"></i>
                    Rombak Jadwal
                </a>
                <a href="{{ route('admin.piket.statistics') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg text-sm shadow-sm transition">
                    <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                    Statistik
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl py-12 mx-auto px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="p-4 mb-4 text-sm border rounded-lg text-emerald-800 bg-emerald-50 border-emerald-200">
                {{ session('success') }}</div>
        @endif

       <!-- Form Pilih Tanggal & Tombol WA -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-6 flex flex-col gap-4">
            <form action="{{ route('admin.piket.index') }}" method="GET" class="flex flex-wrap gap-3 items-end">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Tanggal Piket:</label>
                    <input type="date" name="date" value="{{ $date }}" class="rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
                </div>
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded-lg shadow transition">Cari Data</button>
            </form>

            @if(in_array($dayName, ['Senin', 'Kamis']) && isset($waText) && $waText != "")
                <!-- Mengambil nomor dari database -->
                @php
                    $waNumber = \App\Models\Setting::get('wa_group_number', '');
                @endphp
                
                <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank" rel="noopener noreferrer" class="bg-[#25D366] hover:bg-[#20ba5a] text-white font-bold py-2.5 px-5 rounded-lg shadow-md transition flex items-center gap-2 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M12.04 2C6.59 2 2.18 6.38 2.18 11.81c0 2.05.61 4.04 1.66 5.76L2 22l4.6-1.53a9.8 9.8 0 0 0 5.44 1.73h.01c5.45 0 9.86-4.38 9.86-9.81S17.49 2 12.04 2Zm5.55 13.55c-.24.66-1.42 1.22-1.94 1.29-.5.07-1.13.09-3.68-.77-3.12-1.38-5.12-4.94-5.27-5.17-.15-.23-1.25-1.67-1.25-3.17 0-1.5.77-2.24 1.05-2.54.28-.3.6-.38.8-.38h.57c.18 0 .43.01.66.5.3.64.97 2.2.99 2.38.02.17-.14.41-.27.55-.16.15-.32.35-.46.48-.28.29-.58.63-.4 1.2.18.57 1.03 1.89 2.2 3.06 1.54 1.38 2.8 1.81 3.38 2.01.57.2.91.17 1.24-.1.45-.38 1.09-.95 1.39-1.28.3-.33.61-.28.98-.17.37.11 2.34 1.1 2.75 1.3.4.2.67.3.77.47.1.17.1.98-.13 1.64Z"/>
                    </svg>
                    Kirim Pengingat
                </a>
            @endif
        </div>

        <!-- Form Ceklis Absen -->
        @if (in_array($dayName, ['Senin', 'Kamis']))
            <form action="{{ route('admin.piket.store') }}" method="POST"
                class="p-6 bg-white border border-gray-100 rounded-lg shadow-sm">
                @csrf
                <input type="hidden" name="date" value="{{ $date }}">

                <div class="flex flex-wrap justify-between items-center mb-4 border-b pb-3 gap-3">
                    <h3 class="text-lg font-bold text-emerald-700">Daftar Piket Hari {{ $dayName }}</h3>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" onclick="toggleSemuaCeklis(true)"
                            class="inline-flex items-center gap-1.5 text-xs bg-emerald-100 hover:bg-emerald-200 text-emerald-800 font-bold py-1.5 px-3 rounded-md transition border border-emerald-300">
                            <i data-lucide="check-square" class="w-3.5 h-3.5"></i>
                            Ceklis Semua
                        </button>
                        <button type="button" onclick="toggleSemuaCeklis(false)"
                            class="inline-flex items-center gap-1.5 text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-1.5 px-3 rounded-md transition border border-gray-300">
                            <i data-lucide="square" class="w-3.5 h-3.5"></i>
                            Kosongkan
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <!-- Ikhwan -->
                    <div>
                        <h4 class="pb-2 mb-3 font-bold border-b flex items-center gap-2">
                            <i data-lucide="user" class="w-4 h-4 text-blue-500"></i>
                            Ikhwan
                        </h4>
                        <div class="space-y-2">
                            @foreach ($members->where('gender', 'Ikhwan') as $member)
                                <label
                                    class="flex items-center p-2 border border-transparent rounded cursor-pointer hover:bg-gray-50 hover:border-gray-200">
                                    <input type="checkbox" name="piket_member_ids[]" value="{{ $member->id }}"
                                        class="w-5 h-5 border-gray-300 rounded text-emerald-600 focus:ring-emerald-500"
                                        {{ isset($attendances[$member->id]) && $attendances[$member->id] ? 'checked' : '' }}>
                                    <span class="ml-3 text-gray-700">{{ $member->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <!-- Akhwat -->
                    <div>
                        <h4 class="pb-2 mb-3 font-bold border-b flex items-center gap-2">
                            <i data-lucide="user" class="w-4 h-4 text-purple-500"></i>
                            Akhwat
                        </h4>
                        <div class="space-y-2">
                            @foreach ($members->where('gender', 'Akhwat') as $member)
                                <label
                                    class="flex items-center p-2 border border-transparent rounded cursor-pointer hover:bg-gray-50 hover:border-gray-200">
                                    <input type="checkbox" name="piket_member_ids[]" value="{{ $member->id }}"
                                        class="w-5 h-5 border-gray-300 rounded text-emerald-600 focus:ring-emerald-500"
                                        {{ isset($attendances[$member->id]) && $attendances[$member->id] ? 'checked' : '' }}>
                                    <span class="ml-3 text-gray-700">{{ $member->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 mt-8 border-t">
                    <p class="text-sm text-gray-500">*Ceklis nama yang HADIR piket hari ini</p>
                    <button type="submit"
                        class="px-8 py-3 font-bold text-white transition shadow-lg bg-emerald-600 hover:bg-emerald-700 rounded-xl">Simpan
                        Absensi</button>
                </div>
            </form>
        @else
            <div class="p-6 font-bold text-center text-red-700 border border-red-200 rounded-lg bg-red-50">
                Hari {{ $dayName }} tidak ada jadwal piket. Silakan pilih tanggal yang jatuh pada hari Senin atau
                Kamis.
            </div>
        @endif
    </div>
    <script>
        function toggleSemuaCeklis(status) {
            // Mencari semua input kotak ceklis absensi
            const checkboxes = document.querySelectorAll('input[name="piket_member_ids[]"]');
            
            // Ubah status centangnya secara massal
            checkboxes.forEach(checkbox => {
                checkbox.checked = status;
            });
        }
    </script>
</x-app-layout>