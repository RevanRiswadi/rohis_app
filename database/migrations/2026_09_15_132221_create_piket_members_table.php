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
        Schema::create('piket_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['Ikhwan', 'Akhwat']);
            $table->enum('day', ['Senin', 'Kamis']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piket_members');
    }
};
