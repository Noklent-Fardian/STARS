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
        Schema::create('m_tingkatans', function (Blueprint $table) {
            $table->id();
            $table->string('tingkatan_nama')->unique();
            $table->integer('tingkatan_point')->default(0);
            $table->string('tingkatan_visible')->default('true');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_tingkatans');
    }
};
