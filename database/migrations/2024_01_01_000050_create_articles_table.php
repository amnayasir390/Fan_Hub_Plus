<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('body');
            $table->string('cover_image')->nullable();
            $table->string('article_type')->default('article'); // article, event_highlight, fan_submission
            $table->string('status')->default('published'); // draft, published, pending
            $table->json('tags')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('view_count')->default(0);
            $table->date('event_date')->nullable();
            $table->string('event_location')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
