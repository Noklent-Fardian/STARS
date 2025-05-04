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
        Schema::create('t_keahlian_lombas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lomba_id')->constrained('m_lombas')->onDelete('cascade');
            $table->foreignId('keahlian_id')->constrained('m_keahlians')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_keahlian_lombas');
    }
};
