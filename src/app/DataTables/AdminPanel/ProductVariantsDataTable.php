<?php

namespace App\DataTables\AdminPanel;

use App\Models\AdminPanel\Product;
use App\Models\AdminPanel\ProductVariant;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductVariantsDataTable extends DataTable
{

    /**
     * @var Product
     */
    private $product = null;

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($variant) {
                return "
                <div class=\"flex\">
                    <div data-id=\"{$variant->id}\"class=\" mr-2 btn edit\"></div>
                    <div data-id=\"{$variant->id}\" class=\"btn delete bg-red\"></div>
                </div>
                ";
            })
            ->setRowId('id');
    }

    public function setProduct(Product $product = null)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductVariant $model): QueryBuilder
    {
        $product = $this->product;

        return $model->newQuery()->when($product, function($query) use ($product) {
            $query->where('product_id', $product->id);
        });
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('productvariants-table')
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
            Column::make('title')->title('Название'),
            Column::make('price')->title('Цена'),
            Column::make('count')->title('Количество'),
            Column::make('created_at')->title('Добавлен'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->title('Действия'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ProductVariants_' . date('YmdHis');
    }
}
