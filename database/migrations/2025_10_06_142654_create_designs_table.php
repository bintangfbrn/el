<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('designs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('style')->nullable(); // modern, minimalis, klasik, dll
            $table->text('description')->nullable();
            $table->integer('estimated_cost')->nullable();
            $table->integer('estimated_duration')->nullable(); // dalam hari
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('designs');
    }
};
