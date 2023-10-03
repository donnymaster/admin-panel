<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\OrdersDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request, OrdersDataTable $ordersDataTable)
    {
        return $ordersDataTable->render('admin-panel.orders.index');
    }
}
