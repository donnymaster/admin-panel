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
        'keywords',
        'vendor_code',
        'page_description',
        'image',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
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
