<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function showProgress(){
        $user = Auth::user();
        return view('user.curriculum_progress',compact('user'));
    }
}

