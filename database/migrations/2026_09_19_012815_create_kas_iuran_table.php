<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kas_iuran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('piket_member_id')->constrained('piket_members')->cascadeOnDelete();
            $table->date('tanggal_pertemuan'); // tanggal pertemuan/minggu
            $table->unsignedInteger('nominal')->default(2000);
            $table->boolean('sudah_bayar')->default(false);
            $table->timestamps();

            $table->unique(['piket_member_id', 'tanggal_pertemuan']); // 1 anggota 1x per pertemuan
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kas_iuran');
    }
};
