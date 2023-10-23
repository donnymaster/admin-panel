<?php

namespace App\Models\AdminPanel;

use App\Traits\Model\DateFormatTimeZoneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory, DateFormatTimeZoneTrait;

    protected $fillable = [
        'client_name',
        'position',
        'is_show',
        'comment',
        'rating',
    ];
}
