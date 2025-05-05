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
        Schema::create('t_verifikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('m_mahasiswas')->onDelete('cascade');
            $table->foreignId('penghargaan_id')->constrained('m_penghargaans')->onDelete('cascade');
            $table->foreignId('dosen_id')->constrained('m_dosens')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('m_admins')->onDelete('cascade');
            $table->enum('verifikasi_admin_status', ['Menunggu', 'Diterima', 'Ditolak'])->default('Menunggu');
            $table->enum('verifikasi_dosen_status', ['Menunggu', 'Diterima', 'Ditolak'])->default('Menunggu');
            $table->string('verifikasi_admin_keterangan')->nullable();
            $table->string('verifikasi_dosen_keterangan')->nullable();
            $table->string('verifikasi_admin_tanggal')->nullable();
            $table->string('verifikasi_dosen_tanggal')->nullable();
            $table->boolean('verifikasi_visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_verifikasis');
    }
};
