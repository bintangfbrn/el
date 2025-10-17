<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_id')->constrained('about_us')->onDelete('cascade');
            $table->string('name');
            $table->string('position')->nullable();
            $table->string('photo')->nullable();
            $table->text('description')->nullable();
            $table->json('social_links')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_team');
    }
};
