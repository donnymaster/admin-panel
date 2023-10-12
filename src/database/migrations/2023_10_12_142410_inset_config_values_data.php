<?php

use App\Models\AdminPanel\SiteSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $values = [
            [
                'setting_name' => 'redaktor-tiny-url',
                'setting_key' => 'redaktor-tiny-url',
                'setting_value' => 'https://cdn.tiny.cloud/1/tz1fd8u9lx48w915c8xaguoxxepnd7d4wwktm70glbgpl72c/tinymce/6/tinymce.min.js',
            ]
        ];

        foreach ($values as $value) {
            SiteSetting::create($value);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
