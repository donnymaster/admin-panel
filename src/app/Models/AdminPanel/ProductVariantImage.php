<?php

namespace App\Models\AdminPanel;

use App\Traits\Model\DateFormatTimeZoneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantImage extends Model
{
    use HasFactory, DateFormatTimeZoneTrait;

    protected $fillable = [
        'product_variant_id',
        'slug',
        'path',
        'name',
        'parent_id'
    ];

    public function productVariant()
    {
        return $this->belongsTo(Product::class);
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
