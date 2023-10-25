<?php

namespace App\Models\AdminPanel;

use App\Traits\Model\DateFormatTimeZoneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory, DateFormatTimeZoneTrait;

    protected $fillable = [
        'slug',
        'path',
        'name',
        'size',
        'width',
        'heigth',
        'extension',
        'parent_id',
    ];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function imageable()
    {
        return $this->morphTo();
    }
}
