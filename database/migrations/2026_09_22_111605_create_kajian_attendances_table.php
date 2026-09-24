<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kajian_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('schedules')->cascadeOnDelete();
            $table->foreignId('piket_member_id')->constrained('piket_members')->cascadeOnDelete();
            $table->boolean('hadir')->default(false);
            $table->timestamps();

            $table->unique(['schedule_id', 'piket_member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kajian_attendances');
    }
};
