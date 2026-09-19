<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->paginate(10);

        return view('admin.members.index', compact('members'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $member->update([
            'is_active' => $request->is_active,
        ]);

        return redirect()->back()->with('success', 'Status anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->back()->with('success', 'Anggota berhasil dihapus.');
    }
}
