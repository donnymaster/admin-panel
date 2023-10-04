<?php

namespace App\Models\AdminPanel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name_client',
        'phone_client',
        'additional_information',
        'processed',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
    ];
}
