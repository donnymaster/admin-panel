<?php

namespace App\DataTables\AdminPanel;

use App\Models\AdminPanel\Application;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ApplicationsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            // ->editColumn('phone_client', function($application) {
            //     return "<a href=\"tel:{$application->phone_client}\">{$application->phone_client}</a>";
            // })
            ->editColumn('processed', function($application) {
                if ($application->processed) {
                    return 'Обработан';
                }

                return 'Не обработан';
            })
            ->setRowClass(function ($application) {
                return $application->processed ? 'processed' : 'not-processed';
            })
            // ->addColumn('action', 'applications.action')
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Application $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0, 'asc')
                    ->parameters([
                        'buttons' => [],
                        'language' => [
                            'url' => url('/vendor/datatables/lang/'.app()->getLocale().'.json'),
                        ]]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('full_name_client')->title('Пользователь'),
            Column::make('phone_client')->title('Номер'),
            Column::make('processed')->title('Статус'),
            Column::make('created_at')->title('Создан'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Applications_' . date('YmdHis');
    }
}
