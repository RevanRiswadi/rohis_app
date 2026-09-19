<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Officer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfficerController extends Controller
{
    public function index()
    {
        $officers = Officer::orderBy('order_priority')->orderBy('id')->get();

        return view('admin.officers.index', compact('officers'));
    }

    public function show(Officer $officer)
    {
        return view('admin.officers.show', compact('officer'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'class_major' => 'nullable|string|max:255',
            'order_priority' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'position' => $request->position,
            'class_major' => $request->class_major,
            'order_priority' => $request->order_priority ?? 0,
        ];

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('officers', 'public');
        }

        Officer::create($data);

        return redirect()->route('admin.officers.index')->with('success', 'Pengurus baru berhasil ditambahkan.');
    }

    public function edit(Officer $officer)
    {
        return view('admin.officers.edit', compact('officer'));
    }

    public function update(Request $request, Officer $officer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'class_major' => 'nullable|string|max:255',
            'order_priority' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'position' => $request->position,
            'class_major' => $request->class_major,
            'order_priority' => $request->order_priority ?? 0,
        ];

        if ($request->hasFile('photo')) {
            if ($officer->photo_path && Storage::disk('public')->exists($officer->photo_path)) {
                Storage::disk('public')->delete($officer->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('officers', 'public');
        }

        $officer->update($data);

        return redirect()->route('admin.officers.index')->with('success', 'Data pengurus berhasil diperbarui.');
    }

    public function destroy(Officer $officer)
    {
        if ($officer->photo_path && Storage::disk('public')->exists($officer->photo_path)) {
            Storage::disk('public')->delete($officer->photo_path);
        }

        $officer->delete();

        return redirect()->route('admin.officers.index')->with('success', 'Data pengurus berhasil dihapus.');
    }
}
