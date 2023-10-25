<?php

namespace App\Models\AdminPanel;

use App\Models\User;
use App\Traits\Model\DateFormatTimeZoneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogArticle extends Model
{
    use HasFactory, DateFormatTimeZoneTrait;

    protected $fillable = [
        'title',
        'slug',
        'time_read',
        'description',
        'tiny_description',
        'visible',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
