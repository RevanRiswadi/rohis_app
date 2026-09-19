<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kas_iuran', function (Blueprint $table) {
            // 'rekap' = pertemuan normal & sudah diisi, 'libur' = pertemuan diliburkan
            // NULL = belum diisi sama sekali (hanya ada di generate Sabtu, belum ada row)
            $table->enum('status_pertemuan', ['rekap', 'libur'])->default('rekap')->after('sudah_bayar');
            $table->string('keterangan_libur')->nullable()->after('status_pertemuan');
        });
    }

    public function down(): void
    {
        Schema::table('kas_iuran', function (Blueprint $table) {
            $table->dropColumn(['status_pertemuan', 'keterangan_libur']);
        });
    }
};
