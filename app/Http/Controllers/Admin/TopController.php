<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class TopController extends Controller
{
    use AuthenticatesUsers;

    public function showTop()
    {
        $adminUser = Auth::guard('admin')->user();
        return view('admin.top', ['adminUser' => $adminUser]);
    }

    public function logout(Request $request)
    {
        auth()->guard('admin')->logout(); 
        $request->session()->invalidate();  
        $request->session()->regenerateToken();  

        return redirect('/admin/auth/login');  
    }

    protected function guard() 
    {
        return Auth::guard('admin'); 
    }
}
