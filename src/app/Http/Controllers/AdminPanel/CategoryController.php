<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin-panel.catalogs.categories');
    }
}
