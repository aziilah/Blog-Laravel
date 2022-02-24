<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [ //folder login, index.blade.php
            'title' => 'Login',
            'active' => 'login'
        ]); 
    }

    public function authenticate(Request $request)
    {
       $credentials = $request->validate([
            'email' => 'required|email',    //boleh letak 'required|email:dns'; // dns tu utk kasi strict domain name
            'password' => 'required'

       ]);

       //jika kita jalankan Class Auth, lalu attempt dari $credential, lalu request sesion regenerate utk hindar hacking oleh hacker guna sesion, dan redirect ke route baru, guna intended() method yg akan redirect user ke sebuah tempat/url sebelum melewati sebuah authentication middleware
       //if success login
       if(Auth::attempt($credentials)) {
           $request->session()->regenerate();
           return redirect()->intended('/dashboard');
       }
       //if unsuccessful login
       return back()->with('loginError', 'Login Failed!');

    //    dd('berhasilllll loginnnn');
    }

    //bila User tekan button logout
    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        
        request()->session()->regenerateToken();

        return redirect('/');

    }
}
