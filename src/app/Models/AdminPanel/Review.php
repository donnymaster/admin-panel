<?php

namespace App\Models\AdminPanel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'position',
        'is_show',
        'comment',
        'rating',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];
}
