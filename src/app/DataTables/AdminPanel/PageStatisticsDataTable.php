<?php

namespace App\DataTables\AdminPanel;

use App\Models\AdminPanel\Statistic;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PageStatisticsDataTable extends DataTable
{
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

    /**
     * Get the query source of dataTable.
     */
    public function query(Statistic $model): QueryBuilder
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
            Column::make('ip_visitor')->title('ip'),
            Column::make('device_visitor')->title('Устройство'),
            Column::make('browser_visitor')->title('Браузер'),
            Column::make('os_visitor')->title('Операционная система'),
            Column::make('city_visitor')->title('Город'),
            Column::make('page_name_visit')->title('Страница'),
            Column::make('created_at')->title('Дата посещения'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PageStatistics_' . date('YmdHis');
    }
}
