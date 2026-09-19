<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $status = strtolower((string) $request->query('status', 'all'));

        $registrations = Registration::query()
            ->when($status !== 'all', function ($query) use ($status) {
                $query->whereRaw('LOWER(status) = ?', [$status]);
            })
            ->orderByDesc('created_at')
            // Mengubah get() menjadi paginate() untuk membagi data per halaman
            ->paginate(10)->withQueryString();

        return view('admin.registrations.index', compact('registrations', 'status'));
    }

    public function show(Registration $registration)
    {
        return view('admin.registrations.show', compact('registration'));
    }

    public function edit(Registration $registration)
    {
        return view('admin.registrations.edit', compact('registration'));
    }

    public function export()
    {
        $fileName = 'pendaftaran_rohis_'.date('Y-m-d').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $registrations = Registration::orderByDesc('created_at')->get();

        $file = fopen('php://temp', 'r+');
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($file, [
            'No',
            'Nama Lengkap',
            'NISN',
            'No WhatsApp',
            'Kelas',
            'Jurusan',
            'Divisi Pilihan',
            'Alasan',
            'Status',
        ]);

        foreach ($registrations as $index => $row) {
            fputcsv($file, [
                $index + 1,
                $row->full_name,
                $row->nisn,
                $row->whatsapp_number,
                $row->class,
                $row->major,
                $row->preferred_division,
                $row->reason,
                ucfirst($row->status),
            ]);
        }

        rewind($file);
        $csv = stream_get_contents($file);
        fclose($file);

        return response($csv, 200, $headers);
    }

    public function update(Request $request, Registration $registration)
    {
        $rules = [
            'full_name' => 'nullable|string|max:255',
            'nisn' => ['nullable', 'string', 'max:20', 'unique:registrations,nisn,'.$registration->id],
            'class' => 'nullable|string|max:50',
            'major' => 'nullable|string|max:100',
            'whatsapp_number' => 'nullable|string|max:20',
            'reason' => 'nullable|string',
            'preferred_division' => 'nullable|string|max:255',
            'status' => 'nullable|in:pending,accepted,rejected',
        ];

        $request->validate($rules);

        $data = $request->only([
            'full_name',
            'nisn',
            'class',
            'major',
            'whatsapp_number',
            'reason',
            'preferred_division',
            'status',
        ]);

        $registration->fill(array_filter($data, fn ($value) => ! is_null($value)));
        $registration->save();

        if ($registration->status === 'accepted') {
            Member::firstOrCreate(
                ['nisn' => $registration->nisn],
                [
                    'name' => $registration->full_name,
                    'class' => $registration->class,
                    'major' => $registration->major,
                    'whatsapp_number' => $registration->whatsapp_number,
                    'division' => $registration->preferred_division,
                    'is_active' => true,
                ]
            );
        }

        return redirect()->route('admin.registrations.index')->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();

        return redirect()->route('admin.registrations.index')->with('success', 'Data pendaftaran berhasil dihapus.');
    }
}
