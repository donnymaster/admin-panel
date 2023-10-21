<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\ProductCategoryPropertyDataTable;
use App\Http\Controllers\Controller;
use App\Models\AdminPanel\ProductCategoryProperty;
use App\Services\AdminPanel\AjaxService;
use Illuminate\Http\Request;

class ProductCategoryPropertyController extends Controller
{
    public function index(ProductCategoryPropertyDataTable $dataTable)
    {
        return $dataTable->render('admin-panel.properties.index');
    }

    public function ajax(Request $request)
    {
        return (new AjaxService(
            $request,
            new ProductCategoryProperty
        ))->ajax();
    }
}
