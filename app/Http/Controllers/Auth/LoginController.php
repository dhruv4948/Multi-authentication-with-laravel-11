<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function Login(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'email' => 'required |email',
            'password' => 'required ',
        ]);

        if (Auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))) {
            if (Auth()->guard('admin')->user()->role == 'Admin') {
                return redirect()->route('admin.home');
            } else if (Auth()->guard('teamLeaders')->user()->role == 'Team_leaders') {
                return redirect()->route('teamLeader.home');
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('login')->with('error', 'Invalid');
        }
    }




















}
