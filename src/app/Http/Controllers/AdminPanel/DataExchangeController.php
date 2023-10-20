<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Jobs\AdminPanel\ExchangeData1C;
use App\Models\AdminPanel\DataExchange;
use App\Services\AdminPanel\DataEchange1C;
use Illuminate\Http\Request;

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
    public function index()
    {
        return view('admin-panel.data-exchange.index');
    }

    public function checkIsExistsData()
    {
        return response()->json($this->service->checkStatusFiles());
    }

    public function runDataExchange()
    {
        $out = '';
        $code = '';

        $check = DataExchange::where('status', 'df')->get();

        // if ($check->count() >= 1) {
        //     return response([
        //         'message' => 'Обмен уже запущен!'
        //     ], 422);
        // }

        $exchangeData = $this->service->makeModel('run');

        ExchangeData1C::dispatch($exchangeData->id);

        return 'пашла жара';
    }
}
