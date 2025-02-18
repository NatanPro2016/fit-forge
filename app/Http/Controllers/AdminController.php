<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Tranner;
use App\Sex;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

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
    public function createAdmin(Request $request)
    {
        $filds = $request->validate([

            'email' => ['required', 'email', Rule::unique('admins', 'email')],

            'password' => ['required', 'string', 'min:3', 'max:200'],


        ]);


        $filds['email'] = strip_tags($request->input('email'));

        $filds['password'] = strip_tags($request->input('password'));


        $filds['password'] = bcrypt($filds['password']);
        Admin::create($filds);

        return back()->with(['success' => 'Created Successfully']);

    }
    public function createTranner(Request $request)
    {
        $filds = $request->validate([
            'name' => ['required', 'string',],
            'email' => ['required', 'email', Rule::unique('tranners', 'email')],
            'username' => ['required', 'string', 'min:3', 'max:20', Rule::unique('tranners', 'username')],
            'password' => ['required', 'string', 'min:3', 'max:200'],
            'sex' => ['required', new Enum(Sex::class)],
            'age' => ['required', 'integer'],

        ]);

        $filds['name'] = strip_tags($request->input('name'));
        $filds['email'] = strip_tags($request->input('email'));
        $filds['username'] = strip_tags($request->input('username'));
        $filds['password'] = strip_tags($request->input('password'));
        $filds['age'] = strip_tags($request->input('age'));

        $filds['password'] = bcrypt($filds['password']);
        Tranner::create($filds);

        return back()->with(['success' => 'Created Successfully']);
        // return $filds;


    }


}
