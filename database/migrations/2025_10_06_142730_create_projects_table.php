<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('design_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('designer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('status')->default('konsultasi'); // konsultasi, estimasi, dp1, dp2, revisi, proses, selesai
            $table->integer('estimated_cost')->nullable();
            $table->integer('final_cost')->nullable();
            $table->date('estimated_finish')->nullable();
            $table->text('notes')->nullable(); // catatan admin atau user
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
