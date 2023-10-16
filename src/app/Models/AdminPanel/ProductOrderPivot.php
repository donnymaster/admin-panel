<?php

namespace App\Models\AdminPanel;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductOrderPivot extends Pivot
{
    protected $table = 'product_orders';

    public function promocode()
    {
        return $this->belongsTo(Promocode::class, 'promocode_id');
    }
}
