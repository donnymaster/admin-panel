<?php

namespace App\Models\AdminPanel;

use App\Traits\Model\DateFormatTimeZoneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUniqueValue extends Model
{
    use HasFactory, DateFormatTimeZoneTrait;

    protected $fillable = [
        'product_id',
        'unique_name',
        'unique_slug',
        'unique_value',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
