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
        Schema::create('t_keahlian_dosens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')->constrained('m_dosens')->onDelete('cascade');
            $table->foreignId('keahlian_id')->constrained('m_keahlians')->onDelete('cascade');
            $table->string('keahlian_sertifikat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_keahlian_dosens');
    }
};
