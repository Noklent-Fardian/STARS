<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('m_users')->onDelete('cascade');
            $table->string('type');
            $table->string('title');
            $table->text('message');
            $table->string('url');
            $table->string('icon')->default('fas fa-bell');
            $table->string('icon_bg')->default('bg-primary');
            $table->boolean('is_read')->default(false);
            $table->unsignedBigInteger('related_id')->nullable();
            $table->string('related_type')->nullable();
            $table->json('data')->nullable(); 
            $table->timestamps();

            $table->index(['user_id', 'is_read']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};