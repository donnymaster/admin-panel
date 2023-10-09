<?php

namespace App\DataTables\AdminPanel;

use App\Models\AdminPanel\Promocode;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PromocodesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('status', function ($promocode) {
                if ($promocode->status) {
                    return "<div data-status=\"{$promocode->status}\" data-id=\"{$promocode->id}\" class=\"visible\"></div>";
                }

                return "<div data-status=\"{$promocode->status}\" data-id=\"{$promocode->id}\" class=\"not-visible\"></div>";
            })
            ->editColumn('code', function ($promocode) {
                $code = mb_strlen($promocode->code) >= 18 ? mb_substr($promocode->code, 0, 18).'...' : $promocode->code;
                return "<div class=\"copy-code\" style=\"cursor:copy\" title=\"{$promocode->code}\">$code 🗐</div>";
            })
            ->editColumn('name', function ($promocode) {
                $name = mb_strlen($promocode->name) >= 20 ? mb_substr($promocode->name, 0, 20).'...' : $promocode->name;
                return "<div title=\"{$promocode->name}\">$name</div>";
            })
            ->addColumn('action', function ($promocode) {
                return "
                <div class=\"flex\">
                    <div data-id=\"{$promocode->id}\"class=\" mr-2 btn edit\"></div>
                    <div data-id=\"{$promocode->id}\" class=\"btn delete bg-red\"></div>
            </div>
                ";
            })
            ->addColumn('raw_name', function ($promocode) {
                return $promocode->name;
            })
            ->addColumn('raw_code', function ($promocode) {
                return $promocode->code;
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Promocode $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('promocodes-table')
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
            Column::make('status')->title('Статус'),
            Column::make('percentages')->title('Процент'),
            Column::make('code')->title('Код'),
            Column::make('quantity')->title('Количество'),
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
        return 'Promocodes_' . date('YmdHis');
    }
}
