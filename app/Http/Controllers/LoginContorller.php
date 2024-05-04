<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginContorller extends Controller
{
    public function index()
    {
        return view('Login');
    }
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);
        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('account.dashboard');
            } else {
                return redirect()->route('account.login')->with('error','Eiether email or password is incorrect');
            }
        } else {
            return redirect()->route('account.login')->withInput()->withErrors($validator);
        }
    }


    public function register(Request $request)
    {
        return view('Register');
    }

    public function processRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5 | confirmed',
        ]);

        if ($validator->passes()) {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'Employees';
            $user->save();
            return redirect()->route('account.login')->with('success', 'You have registed successfully');

        } else {
        }
        return redirect()->route('account.register')->withInput()->withErrors($validator);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('account.login');
    }

}
