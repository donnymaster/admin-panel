<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\UsersDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\CreateUserRequest;
use App\Http\Requests\AdminPanel\User\LoginRequest;
use App\Models\AdminPanel\AdminRole;
use App\Models\User;
use App\Services\AdminPanel\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request, UsersDataTable $usersDataTable)
    {
        $roles = AdminRole::all();
        $role = $request->get('role_id', null);

        return $usersDataTable->setIdRole($role)->render('admin-panel.users.index', compact('roles'));
    }

    public function login()
    {
        return view('admin-panel.authentication.login');
    }

    public function create()
    {
        $roles = AdminRole::all();

        return view('admin-panel.users.create', compact('roles'));
    }

    public function store(CreateUserRequest $request)
    {
        $user = User::create(array_merge(
            $request->except('password'),
            ['password' => Hash::make($request->get('password'))]
        ));

        return back()->with('successfully', "Пользователь [{$user->name}] создан!");
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
