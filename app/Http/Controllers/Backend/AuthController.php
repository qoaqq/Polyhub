<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function __construct()
    {
    }
    public function index()
    {

        return view('backend.auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|min:8',
        ]);
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        if (Auth::attempt($credentials)) {
                return redirect()->route('admin.index')->with('success', 'Đặng nhập thành công');
        }
        return redirect()->route('auth.login')->with('error', '
        Email hoặc mật khẩu không hợp lệ ');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('auth.login')->with('success', 'Đăng xuất thành công');
    }
}
