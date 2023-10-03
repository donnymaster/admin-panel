<?php

namespace App\Models\AdminPanel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUniqueValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'unique_name',
        'unique_value',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
