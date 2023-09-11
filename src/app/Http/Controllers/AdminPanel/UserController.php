<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // return view();
    }

    public function login()
    {
        return view('admin-panel.authentication.login');
    }
}
