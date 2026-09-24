<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Pengumuman') }}
            </h2>
            <a href="{{ route('admin.announcements.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-lg text-sm shadow-sm transition">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Tambah Pengumuman
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-emerald-800 rounded-lg bg-emerald-50 border border-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-4">Gambar</th>
                                <th class="px-6 py-4">Judul</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Tanggal Dibuat</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($announcements as $announcement)
                                <tr class="bg-white border-b hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 w-32">
                                        @if($announcement->image_path && Storage::disk('public')->exists($announcement->image_path))
                                            <img src="{{ asset('storage/' . $announcement->image_path) }}" class="w-20 h-16 object-cover rounded-md shadow-sm">
                                        @else
                                            <div class="w-20 h-16 bg-gray-100 flex items-center justify-center rounded-md text-xs text-gray-400">No Image</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-gray-900 text-base">{{ $announcement->title }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($announcement->content, 50) }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($announcement->is_published)
                                            <span class="px-3 py-1 text-[11px] font-bold rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">PUBLISH</span>
                                        @else
                                            <span class="px-3 py-1 text-[11px] font-bold rounded-full bg-gray-100 text-gray-600 border border-gray-200">DRAFT</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-700">
                                        {{ $announcement->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-center space-x-2">
                                        <a href="{{ route('admin.announcements.edit', $announcement) }}" class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-1.5 rounded-md text-xs font-bold transition shadow-sm">Edit</a>
                                        <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-white bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded-md text-xs font-bold transition shadow-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                        <p class="text-base font-medium">Belum ada pengumuman.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-100">
                    {{ $announcements->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>