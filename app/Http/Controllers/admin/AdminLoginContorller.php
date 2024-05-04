<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginContorller extends Controller
{
    public function index()
    {
        return view('admin.Adminlogin');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
              if(Auth::guard('admin')->user()->role != 'Admin'){
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login')->with('error', 'You are not authorized');
              }
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('admin.login')->with('error', 'Eiether email or password is incorrect');
            }
        } else {
            return redirect()->route('admin.login')->withInput()->withErrors($validator);
        }
    }


    public function logout()
    {
        Auth::guard(('admin'))->logout();
        return redirect()->route('admin.login');
    }

}
