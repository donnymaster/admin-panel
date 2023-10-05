<?php

namespace App\DataTables\AdminPanel;

use App\Models\AdminPanel\ProductCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('count_properties', function ($category) {
                return $category->properties_count;
            })
            ->editColumn('name', function ($category) {
                return "<a class=\"link\" href=\"".route('admin.catalog.category.show', ['category' => $category->id])."\">{$category->name}</a>";
            })
            ->editColumn('parent_id', function ($category) {
                if ($category->parent) {
                    return "<a class=\"link\" href=\"".route('admin.catalog.category.show', ['category' => $category->id])."\">{$category->parent->name}</a>";
                }
                return '-';
            })
            ->addColumn('product_link', function ($category) {
                return "<a class=\"link\" href=\"".route('admin.products')."?category={$category->id}\">Открыть ({$category->products_count})</a>";
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductCategory $model): QueryBuilder
    {
        return $model->newQuery()->withCount('products')->withCount('properties')->with('parent');
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
            Column::make('slug')->title('Slug'),
            Column::make('parent_id')->title('Родительская категория'),
            Column::make('page_title')->title('Заголовок'),
            Column::make('product_link')->title('Товары'),
            Column::make('count_properties')->title('Свойств'),
            Column::make('created_at')->title('Добавлен'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Category_' . date('YmdHis');
    }
}
