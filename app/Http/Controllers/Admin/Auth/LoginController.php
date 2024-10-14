<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Admin;                          
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; 
use App\Http\Requests\loginRequest; 

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('admin.auth.login');
    }

    use AuthenticatesUsers {                               
        logout as performLogout;                            
    } 

    public function login(loginRequest $request)
    {
    $credentials = $request->only('email', 'password');

    if (Auth::guard('admin')->attempt($credentials)) {
        
        return redirect()->intended('/admin/top');
    }

    return back()->withErrors([
        'email' => 'ログイン情報が正しくありません。',
    ]);
}
}
