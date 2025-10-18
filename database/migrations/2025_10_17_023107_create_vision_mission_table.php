<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vision_mission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_id')->constrained('about_us')->onDelete('cascade');
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vision_mission');
    }
};
