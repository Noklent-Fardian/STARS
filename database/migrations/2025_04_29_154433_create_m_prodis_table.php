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
        Schema::create('m_prodis', function (Blueprint $table) {
            $table->id();
            $table->string('prodi_nama')->unique();
            $table->string('prodi_kode')->unique();
            $table->boolean('prodi_visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_prodis');
    }
};
