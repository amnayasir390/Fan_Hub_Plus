<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('series')->nullable();
            $table->text('bio')->nullable();
            $table->string('image')->nullable();
            $table->string('genre')->nullable();
            $table->json('abilities')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('popularity')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
