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
        Schema::create('m_semesters', function (Blueprint $table) {
            $table->id();
            $table->string('semester_nama')->unique();
            $table->integer('semester_tahun')->default(2000);
            $table->enum('semester_jenis', ['Ganjil', 'Genap'])->default('Ganjil');
            $table->boolean('semester_aktif')->default(true);
            $table->boolean('semester_visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_semesters');
    }
};
