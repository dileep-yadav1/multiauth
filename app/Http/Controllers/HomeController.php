<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    
    function index()
    {
        $role = Auth::user()->role_id;

        if($role == ADMIN_USER_ROLE)
        {
            return view('admin.dashboard');
        }
        else
        {
            return view('dashboard');
        }
    }
}
