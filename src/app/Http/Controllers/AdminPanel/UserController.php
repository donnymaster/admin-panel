<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // return view();
    }

    public function login()
    {
        Auth::login();
        return view('admin-panel.authentication.login');
    }
}
