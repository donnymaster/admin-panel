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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('page_title');
            $table->string('sync_model')->nullable();
            $table->string('vendor_code')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->integer('position_in_category')->default(0);
            $table->boolean('visible')->nullable();
            $table->string('name_tile')->nullable();
            $table->string('keywords')->nullable();
            $table->text('description')->nullable();
            $table->text('page_description')->nullable();

            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
