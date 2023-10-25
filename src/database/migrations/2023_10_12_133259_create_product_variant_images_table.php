<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->string('path');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('size')->nullable();
            $table->string('width')->nullable();
            $table->string('heigth')->nullable();
            $table->string('extension')->nullable();
            $table->nullableMorphs('imageable');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
