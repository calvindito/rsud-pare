<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function changePassword(Request $request)
    {
        if ($request->_token == csrf_token()) {
            $validation = Validator::make($request->all(), [
                'current_password' => 'required',
                'new_password' => 'required',
                'confirm_password' => 'required|same:new_password'
            ], [
                'current_password.required' => 'password saat ini tidak boleh kosong',
                'new_password.required' => 'password baru tidak boleh kosong',
                'confirm_password.required' => 'konfirmasi password tidak boleh kosong',
                'confirm_password.same' => 'konfirmasi password harus sama dengan password baru'
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation);
            } else {
                $currentPassword = $request->current_password;
                $newPassword = $request->new_password;
                $user = Auth::user();
                $dbPassword = $user->password;

                if (!Hash::check($currentPassword, $dbPassword)) {
                    return redirect()->back()->with([
                        'error' => 'Password saat ini yang anda masukan tidak sesuai'
                    ]);
                }

                try {
                    $updatePassword = User::find($user->id)->update([
                        'password' => bcrypt($request->newPassword)
                    ]);

                    return redirect('auth/change-password')->with([
                        'success' => 'Password berhasil diganti'
                    ]);
                } catch (\Exception $e) {
                    return redirect('auth/change-password')->with([
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        $data = [
            'content' => 'change-password'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with(['success' => 'Anda berhasil keluar']);
    }
}
