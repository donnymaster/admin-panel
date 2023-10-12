<?php

namespace App\DataTables\AdminPanel;

use App\Models\AdminPanel\ProductCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;

class CategoryDataTable extends DataTable
{
    private $parent_id = null;

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
                $name = mb_strlen($category->name) >= 20 ? mb_substr($category->name, 0, 20).'...' : $category->name;

                return "<a class=\"link\" href=\"".route('admin.catalog.category.edit', ['category' => $category->id])."\">$name ✎</a>";
            })
            ->editColumn('page_title', function ($category) {
                $name = mb_strlen($category->page_title) >= 20 ? mb_substr($category->page_title, 0, 20).'...' : $category->page_title;

                return $name;
            })
            ->editColumn('parent_id', function ($category) {
                if ($category->parent) {
                    $nameParent = mb_strlen($category->parent->name) >= 10 ? mb_substr($category->parent->name, 0, 10).'...' : $category->parent->name;

                    return "<a class=\"link\" href=\"".route('admin.catalog.categories.page.list')."?parent={$category->parent->id}\">$nameParent 🡵</a>";
                }
                return '-';
            })
            ->addColumn('product_link', function ($category) {
                return "
                    <div class=\"flex\">
                        <a class=\"link mr-3\" href=\"".route('admin.products')."?category={$category->id}\">🡵 ({$category->products_count})</a>
                        <a class=\"link\" href=\"".route('admin.products.create')."?category-id={$category->id}\">+</a>
                    </div>
                ";
            })
            ->setRowId('id');
    }

    public function setParentId($id = null)
    {
        $this->parent_id = $id;

        return $this;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductCategory $model): QueryBuilder
    {
        $parent_id = $this->parent_id;

        return $model
            ->when($parent_id, function ($query) use ($parent_id) {
                return $query->where('parent_id', $parent_id);
            })
            ->newQuery()
            ->withCount(['products', 'properties'])
            ->with('parent');
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
                        // 'select' => true,
                        // 'rowReorder' => ['dataSrc' => 'id', 'editor' => 'editor'],
                        'buttons' => [],
                        'language' => [
                            'url' => url('/vendor/datatables/lang/'.app()->getLocale().'.json'),
                        ]])
                        // ->editors([
                        //     Editor::make()
                        //         ->fields([
                        //             Fields\Text::make('id')
                        //         ])
                        // ])
                    ->orderBy(0, 'asc');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            // Column::make('id')->className('reorder'),
            Column::make('id'),
            Column::make('name')->title('Название'),
            Column::make('parent_id')->title('Родитель'),
            Column::make('page_title')->title('Заголовок'),
            Column::make('product_link')->title('Товары')->exportable(false)->printable(false)->sortable(false)->searchable(false),
            Column::make('count_properties')->title('Свойств')->exportable(false)->printable(false)->sortable(false)->searchable(false),
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
