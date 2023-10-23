<?php

namespace App\Models\AdminPanel;

use App\Traits\Model\DateFormatTimeZoneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory, DateFormatTimeZoneTrait;

    protected $fillable = [
        'setting_name',
        'setting_key',
        'setting_value',
    ];
}
