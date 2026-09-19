<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('piket_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('piket_member_id')->constrained('piket_members')->onDelete('cascade');
            $table->date('date');
            $table->boolean('is_present')->default(false);
            $table->timestamps();

            // Mencegah absen ganda di hari yang sama
            $table->unique(['piket_member_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piket_attendances');
    }
};
