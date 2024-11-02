<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        return view('login.index');
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $credentials['is_actived'] = true;

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('admin');
            // return redirect()->intended('/');
        }

        return back()->withErrors([
            'password' => 'Thông tin đăng nhập không chính xác',
        ])->onlyInput('username');
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login.index');
    }
}
