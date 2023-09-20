<?php

namespace App\Models\AdminPanel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'slug',
        'page_title',
        'name_tile',
        'price',
        'count',
        'keywords',
        'page_description',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
