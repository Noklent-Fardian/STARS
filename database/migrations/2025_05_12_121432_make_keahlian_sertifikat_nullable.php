<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeKeahlianSertifikatNullable extends Migration
{
    public function up()
    {
        Schema::table('m_keahlians', function (Blueprint $table) {
            $table->string('keahlian_sertifikat')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('m_keahlians', function (Blueprint $table) {
            $table->string('keahlian_sertifikat')->nullable(false)->change();
        });
    }
}
