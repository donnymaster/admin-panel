<?php

namespace App\DataTables\AdminPanel;

use App\Models\AdminPanel\DataExchange;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DataExchangeDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('user', fn ($data) => $data->user->name)
            ->editColumn('status', function ($data) {
                if ($data->status == 'create') {
                    return "<div class=\"badge-mini orange\">добавлен</div>";
                }
                if ($data->status == 'run') {
                    return "<div class=\"badge-mini green\">запущен</div>";
                }
                if ($data->status == 'complete') {
                    return "<div class=\"badge-mini blue\">завершен</div>";
                }
                if ($data->status == 'error') {
                    return "<div class=\"badge-mini red\">ошибка</div>";
                }
            })
            ->editColumn('error_message', function ($data) {
                $message = mb_strlen($data->error_message) >= 20 ? mb_substr($data->error_message, 0, 20) . '...' : $data->error_message;

                return "
                    <div title=\"{$data->error_message}\">{$message}</div>
                ";
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(DataExchange $model): QueryBuilder
    {
        return $model->newQuery()->with('user');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('dataexchange-table')
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
            Column::make('status')->title('Статус'),
            Column::make('user')->title('Инициатор'),
            Column::make('version_schema_import_file')->title('Версия файлов'),
            Column::make('data_formations_import_file')->title('Дата файлов'),
            Column::make('created_at')->title('Добавлен'),
            Column::make('date_end')->title('Остановлен'),
            Column::make('error_message')->title('Ошибка'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'DataExchange_' . date('YmdHis');
    }
}
