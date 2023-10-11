<?php

namespace App\DataTables\AdminPanel;

use App\Models\AdminPanel\Order;
use App\Services\AdminPanel\OrderService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OrdersDataTable extends DataTable
{
    private $status = '';

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('checked', function ($order) {
                return "
                    <div class=\"checkbox\">
                        <input data-id=\"{$order->id}\" class=\"custom-checkbox\" type=\"checkbox\" id=\"select-order-{$order->id}\">
                        <label for=\"select-order-{$order->id}\"></label>
                    </div>
                ";
            })
            ->editColumn('status', function ($order) {
                if ($order->status === OrderService::STATUS_ORDER_NEW) {
                    return "
                        <div class=\"badge-order new\">новый</div>
                    ";
                } else if ($order->status === OrderService::STATUS_ORDER_PROCESSED) {
                    return "
                        <div class=\"badge-order processed\">закрыт</div>
                    ";
                } else if ($order->status === OrderService::STATUS_ORDER_IN_PROCESSING) {
                    return "
                        <div class=\"badge-order in-processing\">в обработке</div>
                    ";
                }
            })
            ->addColumn('action', function ($order) {
                return "
                <div class=\"flex\">
                   <a href=\"".route('admin.orders.show', ['order' => $order->id])."\" class=\"link\">🡵</a>
                </div>
                ";
            })
            ->editColumn('count_products', function ($order) {
                return 5;
            })
            ->addColumn('raw_count_statuses', function () {
                return OrderService::getCountOrdersByStatuses();
            })
            ->setRowId('id');
    }

    public function setStatus($status = ''): self
    {
        if (in_array($status, OrderService::getStatusByArray())) {
            $this->status = $status;
        }

        return $this;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        $status = $this->status;

        return $model->newQuery()->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        });
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('orders-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->parameters([
                        'buttons' => [],
                        'language' => [
                            'url' => url('/vendor/datatables/lang/'.app()->getLocale().'.json'),
                        ]])
                    ->orderBy(0, 'asc');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::computed('checked')->title($this->getCheckboxTitle()),
            Column::make('client_name')->title('Клиент'),
            Column::make('status')->title('Статус'),
            Column::make('phone_number')->title('Телефон'),
            Column::make('total_quantity')->title('Сумма'),
            Column::computed('count_products')->title('Товаров'),
            Column::computed('action')->title('Действия'),
            Column::make('created_at')->title('Добавлен'),

        ];
    }

    public function getCheckboxTitle()
    {
        return "
            <div class=\"checkbox\">
                <input class=\"custom-checkbox\" type=\"checkbox\" id=\"select-all-orders\">
                <label for=\"select-all-orders\"></label>
            </div>
        ";
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Orders_' . date('YmdHis');
    }
}
