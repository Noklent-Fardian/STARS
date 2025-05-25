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
        Schema::create('t_request_tambah_lombas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('m_mahasiswas')->onDelete('cascade');
            $table->foreignId('lomba_id')->nullable()->constrained('m_lombas')->onDelete('cascade');
            $table->string('lomba_nama')->nullable();
            $table->string('lomba_penyelenggara')->nullable();
            $table->string('lomba_kategori')->nullable();
            $table->date('lomba_tanggal_mulai')->nullable();
            $table->date('lomba_tanggal_selesai')->nullable();
            $table->string('lomba_link_pendaftaran')->nullable();
            $table->string('lomba_link_poster')->nullable();
            $table->foreignId('lomba_tingkatan_id')->nullable()->constrained('m_tingkatans')->onDelete('cascade');
            $table->json('lomba_keahlian_ids')->nullable();
            $table->enum('pendaftaran_status', ['Menunggu', 'Diterima', 'Ditolak'])->default('Menunggu');
            $table->timestamp('pendaftaran_tanggal_pendaftaran')->nullable();
            $table->boolean('pendaftaran_visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_request_tambah_lombas');
    }
};