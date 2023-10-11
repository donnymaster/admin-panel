<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\OrdersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\UpdateOrdersStatusRequest;
use App\Models\AdminPanel\Order;
use App\Services\AdminPanel\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $service = null;

    public function __construct()
    {
        $this->service = new OrderService();
    }

    public function index(Request $request, OrdersDataTable $ordersDataTable)
    {
        $informationStatuses = OrderService::getCountOrdersByStatuses();

        return $ordersDataTable
            ->response(function ($data) {
                $data['countStatuses'] = OrderService::getCountOrdersByStatuses();
                return $data;
            })
            ->setStatus($request->get('status_type'))
            ->render('admin-panel.orders.index', compact('informationStatuses'));
    }

    public function changeStatus(UpdateOrdersStatusRequest $request)
    {
        $data = $request->all();

        Order::whereIn('id', $data['orders_id'])->update(['status' => $data['type']]);

        OrderService::log($data['orders_id'], 'update_status_'.$data['type']);

        return [
            'message' => 'Заказы были обновлены!',
        ];
    }

    public function show(Order $order)
    {
        dd($order);
    }
}
