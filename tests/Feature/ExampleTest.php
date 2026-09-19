<?php

namespace Tests\Feature;

use App\Models\Officer;
use App\Models\Registration;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('officers')) {
            Schema::create('officers', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('position');
                $table->string('class_major')->nullable();
                $table->string('photo_path')->nullable();
                $table->unsignedInteger('order_priority')->default(0);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('schedules')) {
            Schema::create('schedules', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->dateTime('event_date')->nullable();
                $table->string('location')->nullable();
                $table->string('speaker')->nullable();
                $table->string('status')->default('upcoming');
                $table->string('image_path')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('faqs')) {
            Schema::create('faqs', function (Blueprint $table) {
                $table->id();
                $table->string('question');
                $table->text('answer');
                $table->unsignedInteger('order_priority')->default(0);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('registrations')) {
            Schema::create('registrations', function (Blueprint $table) {
                $table->id();
                $table->string('full_name');
                $table->string('nisn')->unique();
                $table->string('class');
                $table->string('major');
                $table->string('whatsapp_number');
                $table->text('reason');
                $table->string('preferred_division');
                $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('members')) {
            Schema::create('members', function (Blueprint $table) {
                $table->id();
                $table->string('nisn')->unique();
                $table->string('name');
                $table->string('class');
                $table->string('major');
                $table->string('whatsapp_number');
                $table->string('division');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('galleries')) {
            Schema::create('galleries', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('image_path');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_homepage_uses_the_configured_hero_image_when_available(): void
    {
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAF ');
        Storage::disk('public')->put('hero/custom-hero.jpg', $png);
        Setting::set('hero_image', 'hero/custom-hero.jpg');

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee(asset('storage/hero/custom-hero.jpg'));
        $response->assertDontSee('images.unsplash.com');
    }

    public function test_homepage_falls_back_when_the_saved_hero_image_is_not_a_valid_image(): void
    {
        Storage::disk('public')->put('hero/broken.png', 'not-a-real-image');
        Setting::set('hero_image', 'hero/broken.png');

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('images.unsplash.com');
        $response->assertDontSee(asset('storage/hero/broken.png'));
    }

    public function test_homepage_uses_custom_social_links_from_settings(): void
    {
        Setting::set('social_instagram', 'https://instagram.com/custom.account');
        Setting::set('social_whatsapp', 'https://wa.me/6281234567890');
        Setting::set('social_youtube', 'https://youtube.com/@customchannel');

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('https://instagram.com/custom.account');
        $response->assertSee('https://wa.me/6281234567890');
        $response->assertSee('https://youtube.com/@customchannel');
    }

    public function test_officers_table_has_the_columns_required_by_the_homepage(): void
    {
        if (! Schema::hasTable('officers')) {
            Schema::create('officers', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('position');
                $table->string('class_major')->nullable();
                $table->string('photo_path')->nullable();
                $table->unsignedInteger('order_priority')->default(0);
                $table->timestamps();
            });
        }

        $this->assertTrue(Schema::hasColumn('officers', 'class_major'));
        $this->assertTrue(Schema::hasColumn('officers', 'photo_path'));
        $this->assertTrue(Schema::hasColumn('officers', 'order_priority'));
    }

    public function test_dashboard_counts_pending_registrations(): void
    {
        Registration::create([
            'full_name' => 'Test Pending',
            'nisn' => '1234567890',
            'class' => 'XI',
            'major' => 'PPLG',
            'whatsapp_number' => '081234567890',
            'reason' => 'Testing pending status count.',
            'preferred_division' => 'Multimedia',
            'status' => 'pending',
        ]);

        $this->assertSame(1, Registration::pendingCount());
    }

    public function test_duplicate_nisn_registration_returns_validation_error(): void
    {
        Registration::create([
            'full_name' => 'Pendaftar Lama',
            'nisn' => '1234567890',
            'class' => 'XI',
            'major' => 'PPLG',
            'whatsapp_number' => '081234567890',
            'reason' => 'Sudah ada',
            'preferred_division' => 'Multimedia',
            'status' => 'pending',
        ]);

        $response = $this->from('/daftar')->post('/daftar', [
            'full_name' => 'Pendaftar Baru',
            'nisn' => '1234567890',
            'class' => 'XI',
            'major' => 'PPLG',
            'whatsapp_number' => '081234567891',
            'preferred_division' => 'Multimedia',
            'reason' => 'Coba daftar lagi',
        ]);

        $response->assertSessionHasErrors('nisn');
        $response->assertRedirect('/daftar');
    }

    public function test_get_daftar_route_returns_registration_page(): void
    {
        $response = $this->get('/daftar');

        $response->assertStatus(200);
        $response->assertSee('Formulir Pendaftaran Anggota Baru');
    }

    public function test_admin_registration_index_filters_by_status(): void
    {
        $user = User::factory()->create();

        Registration::create([
            'full_name' => 'Pending User',
            'nisn' => '1111111111',
            'class' => 'XI',
            'major' => 'PPLG',
            'whatsapp_number' => '081111111111',
            'reason' => 'Pending',
            'preferred_division' => 'Multimedia',
            'status' => 'pending',
        ]);

        Registration::create([
            'full_name' => 'Accepted User',
            'nisn' => '2222222222',
            'class' => 'XI',
            'major' => 'PPLG',
            'whatsapp_number' => '082222222222',
            'reason' => 'Accepted',
            'preferred_division' => 'Multimedia',
            'status' => 'accepted',
        ]);

        $response = $this->actingAs($user)->get('/admin/registrations?status=pending');

        $response->assertOk();
        $response->assertSee('Pending User');
        $response->assertDontSee('Accepted User');
    }

    public function test_admin_dashboard_has_website_preview_link(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertOk();
        $response->assertSee('Preview Website');
    }

    public function test_dashboard_shows_counts_for_all_registration_statuses(): void
    {
        Registration::create([
            'full_name' => 'Pending User',
            'nisn' => '1111111111',
            'class' => 'XI',
            'major' => 'PPLG',
            'whatsapp_number' => '081111111111',
            'reason' => 'Pending',
            'preferred_division' => 'Multimedia',
            'status' => 'pending',
        ]);

        Registration::create([
            'full_name' => 'Accepted User',
            'nisn' => '2222222222',
            'class' => 'XI',
            'major' => 'PPLG',
            'whatsapp_number' => '082222222222',
            'reason' => 'Accepted',
            'preferred_division' => 'Multimedia',
            'status' => 'accepted',
        ]);

        Registration::create([
            'full_name' => 'Rejected User',
            'nisn' => '3333333333',
            'class' => 'XI',
            'major' => 'PPLG',
            'whatsapp_number' => '083333333333',
            'reason' => 'Rejected',
            'preferred_division' => 'Multimedia',
            'status' => 'rejected',
        ]);

        $counts = Registration::statusCounts();

        $this->assertSame(1, $counts['pending']);
        $this->assertSame(1, $counts['accepted']);
        $this->assertSame(1, $counts['rejected']);
    }

    public function test_admin_can_view_registration_detail_page(): void
    {
        $user = User::factory()->create();

        $registration = Registration::create([
            'full_name' => 'Detail User',
            'nisn' => '4444444444',
            'class' => 'XII',
            'major' => 'TKJ',
            'whatsapp_number' => '084444444444',
            'reason' => 'Mau ikut Rohis',
            'preferred_division' => 'Dakwah',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get('/admin/registrations/'.$registration->id);

        $response->assertOk();
        $response->assertSee('Detail User');
        $response->assertSee('Dakwah');
    }

    public function test_admin_can_export_registrations_as_csv(): void
    {
        $user = User::factory()->create();

        Registration::create([
            'full_name' => 'Export User',
            'nisn' => '5555555555',
            'class' => 'XI',
            'major' => 'PPLG',
            'whatsapp_number' => '085555555555',
            'reason' => 'Need export',
            'preferred_division' => 'Multimedia',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get('/admin/registrations/export');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $response->assertSee('Nama Lengkap');
        $response->assertSee('Export User');
    }

    public function test_public_can_view_officers_page(): void
    {
        Officer::create([
            'name' => 'Ketua Rohis',
            'position' => 'Ketua Umum',
            'class_major' => 'XII PPLG 1',
        ]);

        $response = $this->get('/pengurus');

        $response->assertOk();
        $response->assertSee('Susunan Pengurus Rohis Darul Muttaqin');
        $response->assertSee('Ketua Rohis');
        $response->assertSee('Ketua Umum');
    }

    public function test_admin_can_create_officer_with_photo(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('officer.jpg');

        $response = $this->actingAs($user)->post('/admin/officers', [
            'name' => 'Pengurus Foto',
            'position' => 'Bendahara',
            'class_major' => 'XI AKL 2',
            'order_priority' => 1,
            'photo' => $file,
        ]);

        $response->assertRedirect(route('admin.officers.index'));
        $officer = Officer::where('name', 'Pengurus Foto')->first();
        $this->assertNotNull($officer);
        $this->assertNotNull($officer->photo_path);
        Storage::disk('public')->assertExists($officer->photo_path);
    }

    public function test_admin_can_view_officer_detail_page(): void
    {
        $user = User::factory()->create();
        $officer = Officer::create([
            'name' => 'Pengurus Detail',
            'position' => 'Sekretaris',
        ]);

        $response = $this->actingAs($user)->get('/admin/officers/'.$officer->id);

        $response->assertOk();
        $response->assertSee('Pengurus Detail');
        $response->assertSee('Sekretaris');
    }

    public function test_admin_can_edit_officer_record(): void
    {
        $user = User::factory()->create();
        $officer = Officer::create([
            'name' => 'Pengurus Lama',
            'position' => 'Ketua',
        ]);

        $response = $this->actingAs($user)->put('/admin/officers/'.$officer->id, [
            'name' => 'Pengurus Baru',
            'position' => 'Wakil Ketua',
        ]);

        $response->assertRedirect(route('admin.officers.index'));
        $this->assertDatabaseHas('officers', [
            'id' => $officer->id,
            'name' => 'Pengurus Baru',
            'position' => 'Wakil Ketua',
        ]);
    }

    public function test_admin_can_edit_registration_record(): void
    {
        $user = User::factory()->create();
        $registration = Registration::create([
            'full_name' => 'Pendaftar Lama',
            'nisn' => '6666666666',
            'class' => 'XI',
            'major' => 'PPLG',
            'whatsapp_number' => '086666666666',
            'reason' => 'Awal',
            'preferred_division' => 'Multimedia',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->put('/admin/registrations/'.$registration->id, [
            'full_name' => 'Pendaftar Baru',
            'nisn' => '6666666667',
            'class' => 'XII',
            'major' => 'TKJ',
            'whatsapp_number' => '086666666667',
            'reason' => 'Baru diubah',
            'preferred_division' => 'Dakwah',
            'status' => 'pending',
        ]);

        $response->assertRedirect(route('admin.registrations.index'));
        $this->assertDatabaseHas('registrations', [
            'id' => $registration->id,
            'full_name' => 'Pendaftar Baru',
            'nisn' => '6666666667',
            'preferred_division' => 'Dakwah',
        ]);
    }
}
