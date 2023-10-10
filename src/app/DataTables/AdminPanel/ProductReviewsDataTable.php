<?php

namespace App\DataTables\AdminPanel;

use App\Models\AdminPanel\ProductReview;
use App\Models\AdminPanel\ProductVariant;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductReviewsDataTable extends DataTable
{
    private $variant = null;

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('name_variant', function ($review) {
                return $review->productVariant->product->name;
            })
            ->editColumn('visible', function ($review) {
                if ($review->visible) {
                    return "<div data-status=\"{$review->visible}\" data-id=\"{$review->id}\" class=\"visible\"></div>";
                }

                return "<div data-status=\"{$review->visible}\" data-id=\"{$review->id}\" class=\"not-visible\"></div>";
            })
            ->addColumn('action', function ($review) {
                return "
                    <div class=\"flex\">
                        <div data-id=\"{$review->id}\" class=\"btn show mr-2\"></div>
                        <div data-id=\"{$review->id}\" class=\"btn delete bg-red mr-2\"></div>
                        <div data-id=\"{$review->id}\" class=\"btn edit bg-green\"></div>
                    </div>
                ";
            })
            ->setRowId('id');
    }

    public function setVariant(ProductVariant $variant = null)
    {
        if (!$variant) {
            return $this;
        }

        $this->variant = $variant;

        return $this;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductReview $model): QueryBuilder
    {
        $variant = $this->variant;

        if ($variant) {
            return $model->newQuery()->with(['productVariant' => function ($query) use ($variant) {
                $query->where('id', $variant->id)->with('product');
            }]);
        }

        return $model->newQuery()->with('productVariant.product');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('productreviews-table')
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
            Column::make('name_variant')->title('Товар'),
            Column::make('rating')->title('Балы'),
            Column::make('client_name')->title('Клиент'),
            Column::make('position')->title('Позиция'),
            Column::computed('visible')
            ->exportable(false)
            ->printable(false)
            ->sortable(true)
            ->title('Статус'),
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
        return 'ProductReviews_' . date('YmdHis');
    }
}
