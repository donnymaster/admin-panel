<?php

namespace App\DataTables\AdminPanel;

use App\Models\AdminPanel\ProductCategoryProperty;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductCategoryPropertiesDataTable extends DataTable
{
    private $categoryId = null;

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id');
    }

    public function setIdCategory($id)
    {
        $this->categoryId = $id;

        return $this;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductCategoryProperty $model): QueryBuilder
    {
        return $model->newQuery()->where('product_category_id', $this->categoryId);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
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
            Column::make('name')->title('Название'),
            Column::make('created_at')->title('Дата создания'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ProductCategoryProperties_' . date('YmdHis');
    }
}
