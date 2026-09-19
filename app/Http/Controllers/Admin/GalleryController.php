<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(10);

        return view('admin.galleries.index', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = $request->file('image')->store('galleries', 'public');

        Gallery::create([
            'title' => $request->title,
            'image_path' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Foto berhasil ditambahkan ke Galeri!');
    }

    // --- FUNGSI UPDATE UNTUK MENYEMBUNYIKAN / MENGUBAH STATUS FOTO ---
    public function update(Request $request, Gallery $gallery)
    {
        // Contoh jika ingin mengubah judul atau status visibilitas
        if ($request->has('title')) {
            $gallery->update([
                'title' => $request->title,
            ]);
        }

        // Jika Anda menggunakan fitur sembunyi/tampilkan (is_hidden / is_active)
        if ($request->has('is_hidden')) {
            $gallery->update([
                'is_hidden' => $request->is_hidden,
            ]);
        }

        return redirect()->back()->with('success', 'Status galeri berhasil diperbarui!');
    }

    public function destroy(Gallery $gallery)
    {
        if (Storage::disk('public')->exists($gallery->image_path)) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        return redirect()->back()->with('success', 'Foto berhasil dihapus dari Galeri!');
    }
}
