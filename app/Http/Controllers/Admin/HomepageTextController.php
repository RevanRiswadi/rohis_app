<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomepageTextController extends Controller
{
    public function index()
    {
        return view('admin.settings.texts');
    }

    public function update(Request $request)
    {
        // Tambahkan wa_group_number ke dalam array
        $data = $request->only([
            'hero_badge',
            'hero_title_main',
            'hero_title_highlight',
            'hero_description',
            'wa_group_number', // <--- BARIS INI DITAMBAHKAN
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
