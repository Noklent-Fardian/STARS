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
        // $table->id();
        //     $table->foreignId('user_id')->constrained('m_users')->onDelete('cascade');
        //     $table->foreignId('prodi_id')->constrained('m_prodis')->onDelete('cascade');
        //     $table->string('dosen_nama')->unique();
        //     $table->string('dosen_nip')->unique();
        //     $table->enum('dosen_status', ['Aktif', 'Tidak Aktif', 'Cuti','Luar Biasa','Studi']);
        //     $table->enum('dosen_gender', ['Laki-laki', 'Perempuan']);
        //     $table->string('dosen_nomor_telepon')->nullable();
        //     $table->string('dosen_photo')->nullable();
        //     $table->string('dosen_provinsi')->nullable();
        //     $table->string('dosen_kota')->nullable();
        //     $table->string('dosen_kecamatan')->nullable();
        //     $table->string('dosen_desa')->nullable();
        //     $table->integer('dosen_point')->default(0);
        //     $table->boolean('dosen_visible')->default(true);
        Schema::create('m_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('m_users')->onDelete('cascade');
            $table->foreignId('prodi_id')->constrained('m_prodis')->onDelete('cascade');
            $table->foreignId('keahlian_id')->constrained('m_keahlians')->onDelete('cascade');
            $table->string('mahasiswa_nama');
            $table->string('mahasiswa_nim')->unique();
            $table->enum('mahasiswa_status', ['Aktif', 'Tidak Aktif', 'Cuti']);
            $table->enum('mahasiswa_gender', ['Laki-laki', 'Perempuan']);
            $table->integer('mahasiswa_angakatan')->default(2000);
            $table->string('mahasiswa_nomor_telepon')->nullable();
            $table->string('mahasiswa_photo')->nullable();
            $table->string('mahasiswa_agama')->nullable();
            $table->string('mahasiswa_provinsi')->nullable();
            $table->string('mahasiswa_kota')->nullable();
            $table->string('mahasiswa_kecamatan')->nullable();
            $table->string('mahasiswa_desa')->nullable();
            $table->integer('mahasiswa_score')->default(0);
            $table->boolean('keahlian_visible')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_mahasiswas');
    }
};
