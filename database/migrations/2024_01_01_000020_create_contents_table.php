<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('content_type')->default('article'); // article, profile, media
            $table->string('genre')->nullable();
            $table->integer('release_year')->nullable();
            $table->integer('popularity')->default(0);
            $table->integer('view_count')->default(0);
            $table->string('status')->default('published'); // draft, published, pending
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->json('tags')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
