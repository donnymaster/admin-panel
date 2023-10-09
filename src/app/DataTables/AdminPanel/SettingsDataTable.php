<?php

namespace App\DataTables\AdminPanel;

use App\Models\AdminPanel\SiteSetting;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SettingsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->editColumn('setting_value', function($variable) {
                if (mb_strlen($variable->setting_value)>= 35) {
                    return mb_substr($variable->setting_value, 0, 35) . '...';
                }

                return $variable->setting_value;
            })
            ->addColumn('full_slug', function($variable) {
                return $variable->setting_value;
            })
            ->addColumn('action', function ($setting) {
                return "
                <div class=\"flex\">
                    <div data-id=\"{$setting->id}\" class=\" mr-2 btn edit modal-btn\" data-update=\"update\"></div>
                    <div data-id=\"{$setting->id}\" class=\"btn delete bg-red\" data-delete=\"delete\"></div>
                </div>
                ";
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SiteSetting $model): QueryBuilder
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
                    ->orderBy(1);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('setting_name')->title('Название'),
            Column::make('setting_key')->title('Slug'),
            Column::make('setting_value')->title('Значение'),
            Column::make('created_at')->title('Создан'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->title('Действия'),
        ];
    }
}
