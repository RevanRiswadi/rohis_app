<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kas_pengeluaran', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('keperluan');               // misal: Beli sapu, Konsumsi kajian
            $table->unsignedInteger('nominal');
            $table->text('catatan')->nullable();       // detail struk / keterangan tambahan
            $table->string('foto_struk')->nullable();  // path foto struk jika diunggah
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kas_pengeluaran');
    }
};
