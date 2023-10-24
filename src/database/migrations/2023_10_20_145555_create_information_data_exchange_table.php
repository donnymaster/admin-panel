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
        Schema::create('information_data_exchange', function (Blueprint $table) {
            $table->id();
            $table->string('version_schema_import_file');
            $table->string('version_schema_offers_file');
            $table->string('data_formations_import_file');
            $table->string('data_formations_offers_file');
            $table->string('status');
            $table->unsignedBigInteger('user_id');
            $table->string('uniique_id');
            $table->string('time_spent')->nullable();
            $table->timestamp('date_start')->nullable();
            $table->timestamp('date_end')->nullable();
            $table->text('message')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information_data_exchange');
    }
};
