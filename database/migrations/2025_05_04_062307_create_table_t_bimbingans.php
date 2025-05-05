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
        Schema::create('t_bimbingans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('m_mahasiswas')->onDelete('cascade');
            $table->foreignId('dosen_id')->constrained('m_dosens')->onDelete('cascade');
            $table->foreignId('lomba_id')->constrained('m_lombas')->onDelete('cascade');
            $table->enum('bimbingan_status', ['berlangsung', 'selesai','batal'])->default('berlangsung');
            $table->boolean('bimbingan_visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_bimbingans');
    }
};
