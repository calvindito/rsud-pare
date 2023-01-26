<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function profile(Request $request)
    {
        $user = Auth::user();
        $employee_id = $user->employee->id;
        $user_id = $user->id;

        if ($request->_token == csrf_token()) {
            $validation = Validator::make($request->all(), [
                'name' => 'required',
                'postal_code' => 'nullable|digits:5|numeric',
                'phone' => 'nullable|digits_between:8,13|numeric',
                'cellphone' => 'nullable|digits_between:8,13|numeric',
                'email' => 'nullable|email',
                'username' => 'required|unique:users,username,' . $user_id
            ], [
                'name.required' => 'nama tidak boleh kosong',
                'postal_code.digits' => 'kode pos harus 5 karakter',
                'postal_code.numeric' => 'kode pos harus angka',
                'phone.digits_between' => 'no telp min 8 dan maks 13 karakter',
                'phone.numeric' => 'no telp harus angka',
                'cellphone.digits_between' => 'no hp min 8 dan maks 13 karakter',
                'cellphone.numeric' => 'no hp harus angka',
                'email.email' => 'email tidak valid',
                'username.required' => 'username tidak boleh kosong',
                'username.unique' => 'username telah digunakan'
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            } else {
                try {
                    DB::transaction(function () use ($request, $employee_id, $user_id) {
                        Employee::find($employee_id)->update([
                            'name' => $request->name,
                            'city' => $request->city,
                            'address' => $request->address,
                            'postal_code' => $request->postal_code,
                            'phone' => $request->phone,
                            'cellphone' => $request->cellphone,
                            'email' => $request->email,
                            'marital_status' => $request->marital_status
                        ]);

                        User::find($user_id)->update([
                            'username' => $request->username
                        ]);
                    });

                    return redirect('auth/profile')->with([
                        'success' => 'Profil berhasil diganti'
                    ]);
                } catch (\Exception $e) {
                    return redirect('auth/profile')->with([
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        $data = [
            'user' => $user,
            'content' => 'profile'
        ];

        return view('layouts.index', ['data' => $data]);
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
