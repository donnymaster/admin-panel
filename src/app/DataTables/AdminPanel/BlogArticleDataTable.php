<?php

namespace App\DataTables\AdminPanel;

use App\Models\AdminPanel\BlogArticle;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BlogArticleDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($article) {
                return "
                <div class=\"flex\">
                    <div data-id=\"{$article->id}\"class=\" mr-2 btn edit\"></div>
                    <div data-id=\"{$article->id}\" class=\"btn delete bg-red\"></div>
                </div>
                ";
            })
            ->addColumn('user', function ($article) {
                return $article->user->name;
            })
            ->editColumn('visible', function ($article) {
                if ($article->visible) {
                    return "<div data-id=\"{$article->id}\" class=\"visible\"></div>";
                }

                return "<div data-id=\"{$article->id}\" class=\"not-visible\"></div>";
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(BlogArticle $model): QueryBuilder
    {
        return $model->newQuery()->with('user');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('blogarticle-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->parameters([
                        'pageLength' => 10,
                        'buttons' => [],
                        'language' => [
                            'url' => url('/vendor/datatables/lang/' . app()->getLocale() . '.json'),
                        ]
                    ])
                    ->orderBy(0, 'asc');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('title')->title('Заголовок'),
            Column::make('user')->title('Автор'),
            Column::make('visible')->title('Состояние'),
            Column::make('created_at')->title('Добавлен'),
            Column::computed('action')
                ->title('Действия')
                ->exportable(false)
                ->printable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'BlogArticle_' . date('YmdHis');
    }
}
