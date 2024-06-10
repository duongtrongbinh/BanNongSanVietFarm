<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.auth.user");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $remember = $request->has('remember_token') ? true : false;
        if(auth()->attempt([
            'email'=>$request->email,
            'password'=>$request->password
        ], $remember)){
            return view('admin.dashboard');
        }
    }

    public function logout(){
        Auth::logout();
        return view('dashboard.admin.users.user');
    }

    
}