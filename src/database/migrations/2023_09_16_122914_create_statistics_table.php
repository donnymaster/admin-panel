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
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip_visitor');
            $table->text('user_agent');
            $table->string('country_visitor')->nullable();
            $table->string('device_visitor')->nullable();
            $table->string('os_visitor')->nullable();
            $table->string('os_version_visitor')->nullable();
            $table->string('browser_visitor')->nullable();
            $table->string('browser_version_visitor')->nullable();
            $table->string('city_visitor')->nullable();
            $table->string('page_name_visit')->nullable();
            $table->string('page_url_visit')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};
