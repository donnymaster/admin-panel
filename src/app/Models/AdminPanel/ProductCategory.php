<?php

namespace App\Models\AdminPanel;

use App\Traits\Model\DateFormatTimeZoneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory, DateFormatTimeZoneTrait;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'position',
        'page_title',
        'keywords',
        'description',
        'page_description',
        'image',
        'sync_id',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function properties()
    {
        return $this->belongsToMany(ProductCategoryProperty::class, 'category_properties', 'category_id', 'property_id')->withTimestamps();
    }
}
