<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\User\LoginRequest;
use App\Services\AdminPanel\UserService;
use Illuminate\Support\Facades\Auth;

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

    public function loginHandler(LoginRequest $request)
    {
        $validated = $request->safe()->only(['email', 'password']);

        if (Auth::attempt($validated)) {
            return redirect()->intended(UserService::redirectTo());
        } else {
            return redirect()->to(route('get.login'))->withErrors(trans('auth.failed'));
        }
    }
}
