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
        Schema::create('m_penghargaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('m_mahasiswas')->onDelete('cascade');
            $table->foreignId('lomba_id')->constrained('m_lombas')->onDelete('cascade');
            $table->foreignId('peringkat_id')->constrained('m_peringkats')->onDelete('cascade');
            $table->foreignId('tingkatan_id')->constrained('m_tingkatans')->onDelete('cascade');
            $table->string('penghargaan_judul');
            $table->string('penghargaan_tempat');
            $table->string('penghargaan_url');
            $table->date('penghargaan_tanggal_mulai');
            $table->date('penghargaan_tanggal_selesai');
            $table->integer('penghargaan_jumlah_peserta');
            $table->integer('penghargaan_jumlah_instansi');
            $table->string('penghargaan_no_surat_tugas');
            $table->date('penghargaan_tanggal_surat_tugas');
            $table->string('penghargaan_file_surat_tugas');
            $table->string('penghargaan_file_sertifikat');
            $table->string('penghargaan_file_poster');
            $table->string('penghargaan_photo_kegiatan');
            $table->integer('penghargaan_score')->default(0);
            $table->boolean('penghargaan_visible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_penghargaan');
    }
};
