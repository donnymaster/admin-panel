<?php

namespace App\Models\AdminPanel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_variant_id',
        'rating',
        'client_review',
        'client_name',
        'visible',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
    ];

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
