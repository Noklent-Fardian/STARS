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
        Schema::create('m_pdf_settings', function (Blueprint $table) {
            $table->id();
            $table->string('pdf_instansi1')->nullable();
            $table->string('pdf_instansi2')->nullable();
            $table->string('pdf_logo_kiri')->nullable(); //max 100kb
            $table->string('pdf_logo_kanan')->nullable(); //max 100kb
            $table->text('pdf_alamat')->nullable();
            $table->string('pdf_telepon')->nullable();
            $table->string('pdf_fax')->nullable();
              $table->string('pdf_pes')->nullable();
            $table->string('pdf_website')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_pdf_settings');
    }
};
