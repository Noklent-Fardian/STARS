<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('m_bobots', function (Blueprint $table) {
            $table->id();
            $table->string('kriteria'); // contoh: 'score', 'keahlian_utama', 'keahlian_tambahan', 'jumlah_lomba'
            $table->float('bobot');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_bobots');
    }
};