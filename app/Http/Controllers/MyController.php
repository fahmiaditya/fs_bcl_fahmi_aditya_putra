<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyController extends Controller
{
    public function login()
    {
        if (Auth::check()) { // jika sudah ada yang login
            return redirect(route('dashboard'));
        } else {
            return view('login');
        }
    }

    public function doLogin(Request $request)
    {
        $this->validate($request,[
            'account'  => 'required',
            'password' => 'required'
        ]);

        $fieldType = filter_var($request->account, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if (Auth::attempt(array($fieldType => $request->account, 'password' => $request->password))) {
            return redirect(route('dashboard'));
		} else {
			session()->flash('flash_notification', [
                "level"     => "danger",
				"message"   => "Akun atau password Anda salah"
            ]);

            return redirect(route('login'));
		}
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
