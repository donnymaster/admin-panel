<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\Order;
use App\Models\AdminPanel\OrderLog;
use Illuminate\Support\Facades\Auth;

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

    public static function getStatusByArray()
    {
        return [
            self::STATUS_ORDER_IN_PROCESSING,
            self::STATUS_ORDER_NEW,
            self::STATUS_ORDER_PROCESSED,
        ];
    }

    public static function log($order_id, $type_operation)
    {
        if (is_array($order_id)) {

            foreach ($order_id as $id) {
                OrderLog::create([
                    'user_id' => Auth::user()->id,
                    'order_id' => $id,
                    'type_operation' => $type_operation,
                ]);
            }

            return;
        }

        OrderLog::create([
            'user_id' => Auth::user()->id,
            'order_id' => $order_id,
            'type_operation' => $type_operation,
        ]);
    }
}
