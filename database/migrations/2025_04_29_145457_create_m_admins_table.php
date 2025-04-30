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
        Schema::create('m_admins', function (Blueprint $table) {
            $table->id();
            //fk user_id
            $table->foreignId('user_id')->constrained('m_users')->onDelete('cascade');
            $table->string('admin_name');
            $table->enum('admin_gender', ['Laki-laki', 'Perempuan']);
            $table->string('admin_nomor_telepon')->nullable();
            $table->string('admin_photo')->nullable();
            $table->boolean('admin_visible')->default(true);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_admins');
    }
};
