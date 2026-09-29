<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('ratable'); // polymorphic
            $table->tinyInteger('score')->nullable(); // 1-5 stars
            $table->boolean('thumbs_up')->nullable(); // thumbs up/down
            $table->timestamps();

            $table->unique(['user_id', 'ratable_type', 'ratable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
