<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\profile;


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
        // if ($validator->passes()) {
        //     if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
        //         if (Auth::guard('user')->user()->role != 'Employees') {
        //             Auth::guard('user')->logout();
        //             return redirect()->route('account.login')->with('error', 'You are not authorized');
        //         }
        //         return redirect()->route('account.dashboard');
        //     } else {
        //         return redirect()->route('account.login')->with('error', 'Eiether email or password is incorrect');
        //     }
        // } else {
        //     return redirect()->route('account.login')->withInput()->withErrors($validator);
        // }

        if ($validator->passes()) {
            if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
                if (Auth::guard('user')->user()->role == 'Admin') {
                    return redirect()->route('admin.dashboard');
                }
                else if(Auth::guard('user')->user()->role == 'Team_leaders'){
                    return redirect()->route('teamLeader.dashboard');
                }
            } else {
            }
        } else {
            return redirect()->route('account.login')->withInput()->withErrors($validator);
        }
    }


    public function register()
    {
        return view('Register');
    }

    public function processRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'number' => 'required|numeric',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female',
            'education' => 'required',
            'skills' => 'required|array',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'password' => 'required|min:5 |',
        ]);

        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'Employees';
            $user->save();

            $profile = new Profile;
            $profile->number = $request->number;
            $profile->dob = $request->dob;
            $profile->gender = $request->gender;
            $profile->education = $request->education;
            $profile->Interest = implode(',', array_unique($request->skills));
            $profile->address = $request->address;
            $profile->city = $request->city;
            $profile->country = $request->country;
            $user->profile()->save($profile);


            return redirect()->route('account.login')->with('success', 'You have registed successfully');

        } else {
        }
        return redirect()->route('account.register')->withInput()->withErrors($validator);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }

}
