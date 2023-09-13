<?php

namespace App\Models\AdminPanel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'route',
        'title',
        'description',
        'keywords',
        'old_route',
        'canonical_address',
        'page_description',
        'og_title',
        'og_type',
        'og_url',
        'og_image',
        'og_description',
        'og_site_name',
        'og_vk_image',
        'og_fb_image',
        'og_twitter_image',
        'is_show',
    ];
}
