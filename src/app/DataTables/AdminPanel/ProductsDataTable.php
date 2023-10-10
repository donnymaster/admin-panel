<?php

namespace App\DataTables\AdminPanel;

use App\Models\AdminPanel\Product;
use App\Models\AdminPanel\ProductCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductsDataTable extends DataTable
{
    /**
     * @var ProductCategory
     */
    private $category = null;

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('category_id', function ($product) {
                return "<a
                class=\"link\"
                href=\"".route('admin.catalog.category.edit', ['category' => $product->category_id])."\">
                {$product->category->name}
                </a>";
            })
            ->editColumn('name', function ($product) {
                return "<a
                class=\"link\"
                href=\"".route('admin.products.show', ['product' => $product->id])."\">
                {$product->name}
                </a>";
            })
            ->addColumn('count_variants', function ($product) {
                return $product->variants_count;
            })
            ->addColumn('copy', function ($product) {
                $createUrl = route('admin.products.create') . "?parent-id={$product->id}";

                $createUrl .= "&category-id={$product->category_id}";

                return "
                    <a
                        class=\"copy-product\"
                        href=\"$createUrl\">
                    </a>
                ";
            })
            ->editColumn('visible', function ($product) {
                if ($product->visible) {
                    return "<div data-id=\"{$product->id}\" class=\"visible\"></div>";
                }

                return "<div data-id=\"{$product->id}\" class=\"not-visible\"></div>";
            })
            ->addColumn('action', function ($product) {
                return "
                <div class=\"flex\">
                    <div data-id=\"{$product->id}\" class=\"btn delete bg-red mr-2\"></div>
                </div>
                ";
            })
            ->setRowId('id');
    }

    public function setCategory($category): self
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        if ($this->category) {
            return $model->newQuery()->where('category_id', $this->category->id)->with('category')->withCount('variants');
        }

        return $model->newQuery()->with('category')->withCount('variants');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('products-table')
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
            Column::make('category_id')->title('Категория'),
            Column::make('count_variants')->title('Вариантов'),
            Column::computed('visible')->title('Статус'),
            Column::make('copy')->title('Копировать'),
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
        return 'Products_' . date('YmdHis');
    }
}
