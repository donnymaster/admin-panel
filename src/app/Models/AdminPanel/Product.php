<?php

namespace App\Models\AdminPanel;

use App\Traits\Model\DateFormatTimeZoneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, DateFormatTimeZoneTrait;

    protected $fillable = [
        'title',
        'category_id',
        'slug',
        'page_title',
        'name_tile',
        'visible',
        'keywords',
        'position_in_category',
        'vendor_code',
        'page_description',
        'description',
        'sync_model',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function uniqueValues()
    {
        return $this->hasMany(ProductUniqueValue::class, 'product_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function values()
    {
        return $this->morphMany(PropertyValue::class, 'property_value');
    }
}
