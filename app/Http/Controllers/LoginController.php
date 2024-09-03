<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) 
        {
            return redirect('home');
        }
        else
        {
            return view('login');
        }
    }

    public function loginaksi(Request $request)
    {
        if (Auth::attempt(['usernameadmin' => $request->usernameadmin, 'password' => $request->passwordadmin])) {
            return redirect()->route('home')->with('success', 'Login berhasil! Selamat datang di PendidikPay.');
        } else {
            return redirect()->back()->with('error', 'Username atau password salah.');
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Anda berhasil logout. Terima kasih!');
    }
}