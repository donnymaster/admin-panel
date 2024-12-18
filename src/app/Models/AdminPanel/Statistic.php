<?php

namespace App\Models\AdminPanel;

use App\Traits\Model\DateFormatTimeZoneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory, DateFormatTimeZoneTrait;

    protected $fillable = [
        'ip_visitor',
        'user_agent',
        'country_visitor',
        'device_visitor',
        'os_visitor',
        'os_version_visitor',
        'browser_visitor',
        'browser_version_visitor',
        'city_visitor',
        'page_name_visit',
        'page_url_visit',
    ];
}
