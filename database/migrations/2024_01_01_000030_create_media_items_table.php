<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('media_type'); // video, audio, image, trailer
            $table->string('url');
            $table->string('thumbnail')->nullable();
            $table->string('duration')->nullable();
            $table->json('tags')->nullable();
            $table->integer('view_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_items');
    }
};
