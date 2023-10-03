<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataExchangeController extends Controller
{
    public function index()
    {
        return view('admin-panel.data-exchange.index');
    }

    public function edit($id)
    {

    }

    public function store(Request $request, $id)
    {

    }
}
