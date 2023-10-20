<?php

namespace App\Models\AdminPanel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'title',
        'name_tile',
        'price',
        'count',
        'sync_id',
        'vendor_code',
        'slug',
        'model',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function values()
    {
        return $this->morphMany(PropertyValue::class, 'property_value');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_variant_id');
    }

    public function images()
    {
        return $this->hasMany(ProductVariantImage::class, 'product_variant_id');
    }

    public function promocode()
    {
        return $this->hasOne(Promocode::class, 'product_variant_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'product_orders', 'product_variant_id')->withPivot(['count_product']);;
    }
}
