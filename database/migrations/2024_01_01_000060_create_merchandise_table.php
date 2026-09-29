<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchandise', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('badge')->nullable(); // Limited Edition, Pre-Order, Collectible
            $table->string('status')->default('available'); // available, pre-order, sold-out
            $table->date('release_date')->nullable();
            $table->string('buy_link')->nullable();
            $table->integer('view_count')->default(0);
            $table->integer('popularity')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchandise');
    }
};
