<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\OrdersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\AddVariantInOrderRequest;
use App\Http\Requests\AdminPanel\UpdateOrderRequest;
use App\Http\Requests\AdminPanel\UpdateOrdersStatusRequest;
use App\Models\AdminPanel\Order;
use App\Models\AdminPanel\ProductVariant;
use App\Models\AdminPanel\Promocode;
use App\Services\AdminPanel\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $products = $order->variants()->with(['product'])->get()->groupBy('product_id');
        return view('admin-panel.orders.order', compact('order', 'products'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        if ($order->status == OrderService::STATUS_ORDER_PROCESSED) {
            return back();
        }

        $order->update($request->safe()->toArray());

        return back()->with('successfully', 'Заказ был обновлен!');
    }

    public function addVariantInOrder(AddVariantInOrderRequest $request, Order $order)
    {
        $data = $request->safe()->toArray();
        $promocodeId = null;
        $promocode = null;

        if ($data['promocode']) {
            $promocode = Promocode::where([
                'code' => $data['promocode'],
                'status' => true
            ])->first();

            if ($promocode) {
                $promocode->decrement('quantity');
                $promocodeId = $promocode->id;
            }
        }

        $result = DB::table('product_orders')->where([
            'product_variant_id' => $data['variant_id'],
            'order_id' => $order->id
        ])->first();

        if ($result) {
            $dataUpdate = ['count_product' => $result->count_product + $data['count_variants']];

            if ($result->promocode_id) {
                $dataUpdate['promocode_id'] = $result->promocode_id;
                if ($promocode) {
                    $promocode->increment('quantity');
                }
            } else if ($promocodeId) {
                $dataUpdate['promocode_id'] = $promocodeId;
            }

            DB::table('product_orders')->where([
                'product_variant_id' => $data['variant_id'],
                'order_id' => $order->id
            ])->update($dataUpdate);
        } else {
            if ($promocodeId) {
                $order->variants()->attach($data['variant_id'], ['promocode' => $promocodeId, 'count_product' => $data['count_variants']]);
            } else {
                $order->variants()->attach($data['variant_id'], ['count_product' => $data['count_variants']]);
            }
        }

        // decrement count variant
        ProductVariant::where('id', $data['variant_id'])->decrement('count', $data['count_variants']);
    }
}
