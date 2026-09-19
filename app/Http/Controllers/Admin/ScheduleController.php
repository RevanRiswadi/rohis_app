<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::orderBy('event_date', 'desc')->get();

        return view('admin.schedules.index', compact('schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'speaker' => 'nullable|string|max:255',
            'status' => 'required|in:upcoming,completed,cancelled',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:3072',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('schedules', 'public');
        }

        Schedule::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'event_date' => $request->event_date,
            'location' => $request->location,
            'speaker' => $request->speaker,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.schedules.index')->with('success', 'Dokumentasi kegiatan berhasil ditambahkan.');
    }

    public function edit(Schedule $schedule)
    {
        return view('admin.schedules.edit', compact('schedule'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'speaker' => 'nullable|string|max:255',
            'status' => 'required|in:upcoming,completed,cancelled',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:3072',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'location' => $request->location,
            'speaker' => $request->speaker,
            'status' => $request->status,
        ];

        if ($request->hasFile('image')) {
            if ($schedule->image_path && Storage::disk('public')->exists($schedule->image_path)) {
                Storage::disk('public')->delete($schedule->image_path);
            }

            $data['image_path'] = $request->file('image')->store('schedules', 'public');
        }

        $schedule->update($data);

        return redirect()->route('admin.schedules.index')->with('success', 'Dokumentasi kegiatan berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
        if ($schedule->image_path && Storage::disk('public')->exists($schedule->image_path)) {
            Storage::disk('public')->delete($schedule->image_path);
        }

        $schedule->delete();

        return redirect()->route('admin.schedules.index')->with('success', 'Dokumentasi kegiatan berhasil dihapus.');
    }
}
