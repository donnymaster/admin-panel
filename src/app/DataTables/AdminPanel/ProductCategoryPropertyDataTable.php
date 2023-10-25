<?php

namespace App\DataTables\AdminPanel;

use App\Models\AdminPanel\ProductCategoryProperty;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductCategoryPropertyDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($property) {
                return "
                <div class=\"flex\">
                    <div data-id=\"{$property->id}\"class=\" mr-2 btn edit\"></div>
                    <div data-id=\"{$property->id}\" class=\"btn delete bg-red\"></div>
                </div>
                ";
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductCategoryProperty $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('productcategoryproperty-table')
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
            Column::make('name')->title('Названия'),
            Column::make('description')->title('Описание'),
            Column::make('slug')->title('Slug'),
            Column::make('mark')->title('Пометка'),
            Column::make('created_at')->title('Добавлен'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->title('Действие'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ProductCategoryProperty_' . date('YmdHis');
    }
}
