<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        // 1️⃣ Tabel utama - service_highlights
        Schema::create('service_highlights', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // contoh: "Why Choose Us"
            $table->string('subtitle')->nullable(); // contoh: "A behind the scenes look at our agency"
            $table->text('description')->nullable(); // paragraf utama
            $table->timestamps();
        });

        // 2️⃣ Tabel fitur - service_highlight_features
        Schema::create('service_highlight_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('highlight_id')
                ->constrained('service_highlights')
                ->onDelete('cascade');
            $table->string('icon')->nullable(); // path icon atau nama ikon (opsional)
            $table->string('title'); // contoh: "Tailored Design Solutions"
            $table->text('description')->nullable(); // contoh: "We provide personalized interior design..."
            $table->timestamps();
        });

        // 3️⃣ Tabel gambar - service_highlight_images
        Schema::create('service_highlight_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('highlight_id')
                ->constrained('service_highlights')
                ->onDelete('cascade');
            $table->string('image_path'); // contoh: storage/service_highlights/interior1.jpg
            $table->integer('order_index')->default(0); // urutan gambar
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_highlight_images');
        Schema::dropIfExists('service_highlight_features');
        Schema::dropIfExists('service_highlights');
    }
};
