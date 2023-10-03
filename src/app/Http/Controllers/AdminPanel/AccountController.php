<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('admin-panel.account.index', compact('user'));
    }

    public function update(UpdateUserRequest $request)
    {
        $user = Auth::user();

        $user->update($request->except('password'));

        if ($request->has('password')) {
            $user->update(['password' => Hash::make($request->get('password'))]);
        }

        return redirect()->back()->with('successfully', 'Данные были обновлены!');
    }
}
