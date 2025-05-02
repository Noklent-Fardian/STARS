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
        Schema::create('table_m_lombas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keahlian_id')->constrained('m_keahlians')->onDelete('cascade');
            $table->foreignId('tingkatan_id')->constrained('m_tingkatans')->onDelete('cascade');
            $table->foreignId('semester_id')->constrained('m_semesters')->onDelete('cascade');
            $table->string('lomba_nama');;
            $table->string('lomba_penyelenggara');
            $table->string('lomba_kategori');
            $table->date('lomba_tanggal_mulai');
            $table->date('lomba_tanggal_selesai');
            $table->string('lomba_link_pendaftaran');
            $table->string('lomba_link_poster');
            $table->boolean('lomba_visible')->default(true);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_m_lombas');
    }
};
