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
        Schema::create('m_dosens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('m_users')->onDelete('cascade');
            $table->foreignId('prodi_id')->constrained('m_prodis')->onDelete('cascade');
            $table->string('dosen_nama')->unique();
            $table->string('dosen_nip')->unique();
            $table->enum('dosen_status', ['Aktif', 'Tidak Aktif', 'Cuti', 'Studi']);
            $table->enum('dosen_gender', ['Laki-laki', 'Perempuan']);
            $table->string('dosen_nomor_telepon')->nullable();
            $table->string('dosen_photo')->nullable();
            $table->string('dosen_agama')->nullable();
            $table->string('dosen_provinsi')->nullable();
            $table->string('dosen_kota')->nullable();
            $table->string('dosen_kecamatan')->nullable();
            $table->string('dosen_desa')->nullable();
            $table->string('dosen_provinsi_text')->nullable();
            $table->string('dosen_kota_text')->nullable();
            $table->string('dosen_kecamatan_text')->nullable();
            $table->string('dosen_desa_text')->nullable();
            $table->integer('dosen_score')->default(0);
            $table->boolean('dosen_visible')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_dosens');
    }
};
