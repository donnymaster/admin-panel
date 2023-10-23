<?php

namespace App\Models\AdminPanel;

use App\Traits\Model\DateFormatTimeZoneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory, DateFormatTimeZoneTrait;

    protected $fillable = [
        'product_variant_id',
        'rating',
        'client_review',
        'client_name',
        'visible',
        'position',
    ];

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
