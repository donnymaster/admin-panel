<?php

namespace App\Http\Controllers\AdminPanel;

use Illuminate\Http\Request;
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

        $remember = $request->get('remember');

        if (Auth::attempt($validated, $remember)) {
            return redirect()->intended(UserService::redirectToPanel());
        } else {
            return redirect()->to(route('get.login'))->withErrors(['auth' => trans('auth.failed')]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(UserService::redirectToLoginPage());
    }
}
