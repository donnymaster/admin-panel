<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\DataExchangeDataTable;
use App\Http\Controllers\Controller;
use App\Jobs\AdminPanel\ExchangeData1C;
use App\Models\AdminPanel\DataExchange;
use App\Services\AdminPanel\DataEchange1C;

class DataExchangeController extends Controller
{
    /**
     * @var DataEchange1C;
     */
    private $service = null;

    public function __construct()
    {
        $this->service = new DataEchange1C();
    }
    public function index(DataExchangeDataTable $datatable)
    {
        return $datatable->render('admin-panel.data-exchange.index');
    }

    public function checkIsExistsData()
    {
        return response()->json($this->service->checkStatusFiles());
    }

    public function runDataExchange()
    {
        $check = DataExchange::whereIn('status', ['run', 'create'])->get();

        if ($check->count() >= 1) {
            return response([
                'message' => 'Обмен уже создан или запущен!'
            ], 422);
        }

        if (!$this->service->checkExistsFiles()) {
            return response([
                'message' => 'Файла импорта отсутствуют!'
            ], 422);
        }

        $exchangeData = $this->service->makeModel('create');

        ExchangeData1C::dispatch($exchangeData->id);

        return response([
            'message' => 'Задача добавлена в очередь!'
        ]);
    }

    public function removeFiles()
    {
        $this->service->removeFiles();

        return response([
            'message' => 'Файлы были удалены!'
        ]);
    }
}
