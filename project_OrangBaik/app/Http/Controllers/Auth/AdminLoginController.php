<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->usertype == 'admin') {
                return redirect()->intended('/admin/request-bantuan');
            } else {
                Auth::logout();
                return redirect()->route('admin.login')->withErrors(['email' => 'Anda bukan admin!']);
            }
        }

        return redirect()->route('admin.login')->withErrors(['email' => 'Email atau password salah']);
    }
}
