<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('m_users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('user_password');
            $table->enum('user_role', ['Mahasiswa', 'Dosen', 'Admin']);
            $table->boolean('user_visible')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('m_users');
    }
};
