<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Statistik Kehadiran Piket</h2>
    </x-slot>

    <div class="max-w-4xl py-12 mx-auto sm:px-6 lg:px-8">
        <div class="p-6 overflow-hidden bg-white border border-gray-100 shadow-sm sm:rounded-lg">
            <h3 class="mb-4 text-lg font-bold text-gray-900 flex items-center gap-2">
                <i data-lucide="trophy" class="w-5 h-5 text-yellow-500"></i>
                Papan Klasemen Kerajinan Piket
            </h3>
            
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase border-b bg-emerald-50 border-emerald-100">
                    <tr>
                        <th class="px-6 py-4">Peringkat</th>
                        <th class="px-6 py-4">Nama Anggota</th>
                        <th class="px-6 py-4">Ikhwan/Akhwat</th>
                        <th class="px-6 py-4">Jadwal</th>
                        <th class="px-6 py-4 font-bold text-center">Total Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $index => $member)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-xl font-bold {{ $index < 3 ? 'text-yellow-500' : 'text-gray-400' }}">
                                #{{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">{{ $member->name }}</td>
                            <td class="px-6 py-4">{{ $member->gender }}</td>
                            <td class="px-6 py-4">{{ $member->day }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 text-lg font-bold rounded-full bg-emerald-100 text-emerald-800">
                                    {{ $member->attendances_count }}x
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>