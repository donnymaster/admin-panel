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

        OrderService::log($data['orders_id'], 'update_status_' . $data['type']);

        return [
            'message' => 'Заказы были обновлены!',
        ];
    }

    public function show($id)
    {
        $order = Order::where('id', $id)
            ->with(['promocode', 'variants' => function ($query) {
                $query->with('images', function ($query) {
                    $query->where('slug', 'image-mini');
                });
            }])
            ->first();

        return view('admin-panel.orders.order', compact('order'));
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
        $variant_id = $request->get('variant_id');

        $data = [
            'type' => 'create',
        ];

        $result = DB::table('product_orders')->where([
            'product_variant_id' => $variant_id,
            'order_id' => $order->id
        ])->first();

        if ($result) {
            DB::table('product_orders')->where([
                'product_variant_id' => $variant_id,
                'order_id' => $order->id
            ])->update([
                'count_product' => $result->count_product + 1
            ]);
            $data['type'] = 'update';
        } else {
            $order->variants()->attach($variant_id, ['count_product' => 1]);
            $data['variant'] = ProductVariant::where('id', $variant_id)->with(['images' => function ($query) {
                $query->where('slug', 'image-mini');
            }])->first();

        }

        return response($data);
    }

    public function removeVariantInOrder(Request $request, Order $order, $variant)
    {
        $order->variants()->detach($variant);

        return [
            'message' => 'Товар был удален!'
        ];
    }

    public function updateCount(Request $request, $orderId)
    {
        $data = $request->all();

        DB::table('product_orders')->where([
            'product_variant_id' => $data['variant_id'],
            'order_id' => $orderId
        ])->update([
            'count_product' => $data['count']
        ]);

        return [
            'message' => 'Заказ был обновлен!'
        ];
    }
}
