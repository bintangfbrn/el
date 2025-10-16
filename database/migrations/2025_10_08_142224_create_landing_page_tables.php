<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan semua migration untuk landing page.
     */
    public function up(): void
    {
        /**
         * ==========================
         * TABEL: pages
         * ==========================
         */
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->timestamps();
        });

        /**
         * ==========================
         * TABEL: services
         * ==========================
         */
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_2')->nullable();
            $table->decimal('price_estimation', 15, 2)->nullable();
            $table->timestamps();
        });

        /**
         * ==========================
         * TABEL: galleries
         * ==========================
         */
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('image');
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        /**
         * ==========================
         * TABEL: posts
         * ==========================
         */
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->string('thumbnail')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        /**
         * ==========================
         * TABEL: contacts
         * ==========================
         */
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 20)->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Rollback semua tabel.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('services');
        Schema::dropIfExists('pages');
    }
};
