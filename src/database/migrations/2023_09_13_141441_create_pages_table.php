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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('route');
            $table->string('title');
            $table->boolean('is_track')->nullable();
            $table->text('description')->nullable();
            $table->mediumText('keywords')->nullable();
            $table->string('old_route')->nullable();
            $table->string('canonical_address')->nullable();
            $table->mediumText('page_description')->nullable();
            $table->string('og_title')->nullable();
            $table->string('og_type')->nullable();
            $table->string('og_url')->nullable();
            $table->string('og_image')->nullable();
            $table->string('og_description')->nullable();
            $table->string('og_site_name')->nullable();
            $table->string('og_vk_image')->nullable();
            $table->string('og_fb_image')->nullable();
            $table->string('og_twitter_image')->nullable();
            $table->boolean('is_show')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
