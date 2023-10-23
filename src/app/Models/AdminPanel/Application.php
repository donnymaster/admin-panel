<?php

namespace App\Models\AdminPanel;

use App\Traits\Model\DateFormatTimeZoneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory, DateFormatTimeZoneTrait;

    protected $fillable = [
        'full_name_client',
        'phone_client',
        'additional_information',
        'processed',
    ];

}
