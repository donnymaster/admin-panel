<?php

use App\Models\AdminPanel\AdminRole;
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
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super_admin',
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
            ],
        ];

        foreach ($roles as $key => $role) {
            AdminRole::create($role);
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
