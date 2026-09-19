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
        Schema::create('kas', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal'); // Untuk mencatat tanggal uang masuk/keluar
            $table->enum('jenis', ['Pemasukan', 'Pengeluaran']); // Kategori transaksi
            $table->integer('nominal'); // Jumlah uangnya (pakai angka bulat tanpa titik)
            $table->string('keterangan'); // Penjelasan, misal: "Infaq Jumat", "Beli Sapu"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas');
    }
};
