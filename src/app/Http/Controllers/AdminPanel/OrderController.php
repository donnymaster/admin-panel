<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\OrdersDataTable;
use App\Http\Controllers\Controller;
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

        return $ordersDataTable->render('admin-panel.orders.index', compact('informationStatuses'));
    }
}
