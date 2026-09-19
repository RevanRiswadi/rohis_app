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
        Schema::table('officers', function (Blueprint $table) {
            if (! Schema::hasColumn('officers', 'class_major')) {
                $table->string('class_major')->nullable()->after('position');
            }

            if (! Schema::hasColumn('officers', 'photo_path')) {
                $table->string('photo_path')->nullable()->after('class_major');
            }

            if (! Schema::hasColumn('officers', 'order_priority')) {
                $table->unsignedInteger('order_priority')->default(0)->after('photo_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('officers', function (Blueprint $table) {
            $table->dropColumn(['class_major', 'photo_path', 'order_priority']);
        });
    }
};
