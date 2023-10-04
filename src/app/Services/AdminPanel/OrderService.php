<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\Order;

class OrderService
{
    const STATUS_ORDER_NEW = 'new';

    const STATUS_ORDER_IN_PROCESSING = 'in_processing';

    const STATUS_ORDER_PROCESSED = 'processed';

    public static function getCountOrdersByStatuses()
    {
        return [
            self::STATUS_ORDER_NEW => Order::where('status', self::STATUS_ORDER_NEW)->count(),
            self::STATUS_ORDER_IN_PROCESSING => Order::where('status', self::STATUS_ORDER_IN_PROCESSING)->count(),
            self::STATUS_ORDER_PROCESSED => Order::where('status', self::STATUS_ORDER_PROCESSED)->count(),
        ];
    }
}
