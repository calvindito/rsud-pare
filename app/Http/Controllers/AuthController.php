<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect('dashboard/general');
        }

        if ($request->_token == csrf_token()) {
            $username = $request->username;
            $password = $request->password;
            $credentials = ['username' => $username, 'password' => $password, 'status' => true];

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->intended('dashboard/general');
            }

            return back()->with(['failed' => 'Silahkan cek username dan password anda'])->onlyInput('username');
        }

        return view('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with(['success' => 'Anda berhasil keluar']);
    }
}
