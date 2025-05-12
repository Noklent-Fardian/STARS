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
        Schema::table('m_keahlians', function (Blueprint $table) {
            $table->dropColumn('keahlian_sertifikat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_keahlians', function (Blueprint $table) {
            $table->string('keahlian_sertifikat')->nullable();
        });
    }
};