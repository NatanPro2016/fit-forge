<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login()
    {
        return view("admin/admin-login");
    }
    public function loginPost(Request $request)
    {
        $fileds = $request->validate([
            'email' => ['required', 'min:3', 'max:1000', 'email'],
            'password' => ['required', 'min:6', 'max:100']
        ]);

        if (Auth::guard('admin')->attempt($fileds)) {
            return redirect()->intended('/admin/dashboard');
        }


    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->intended('/admin/login');
    }

    public function dashboard()
    {
        return view('admin/admin-dashboard');
    }
}
