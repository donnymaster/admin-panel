<?php

namespace App\Models\AdminPanel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_name',
        'setting_key',
        'setting_value',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
    ];
}
