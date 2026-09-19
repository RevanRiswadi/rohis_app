<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Schedule;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingRegistrations = Registration::pendingCount();
        $statusCounts = Registration::statusCounts();
        $recentSchedules = Schedule::where('status', '!=', 'cancelled')
            ->orderBy('event_date', 'desc')
            ->get();

        return view('admin.dashboard', compact('pendingRegistrations', 'statusCounts', 'recentSchedules'));
    }
}
