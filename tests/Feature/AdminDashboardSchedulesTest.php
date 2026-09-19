<?php

namespace Tests\Feature;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardSchedulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_shows_recent_schedules(): void
    {
        $user = User::factory()->create();

        $schedule = Schedule::create([
            'title' => 'Kajian Akbar Rohis',
            'description' => 'Kajian rutin Rohis',
            'event_date' => now()->subDay(),
            'location' => 'Masjid Sekolah',
            'speaker' => 'Ustadz Hadi',
            'status' => 'upcoming',
        ]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dokumentasi Terbaru')
            ->assertSee($schedule->title);
    }
}
