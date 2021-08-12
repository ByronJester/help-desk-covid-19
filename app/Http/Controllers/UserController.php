<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\RegisterAccount;

class UserController extends Controller
{

	#Login User
    public function login(Request $request)
    {
    	$data = [
    		'email' => $request->email,
    		'password' => $request->password,
    	];

        $user = User::where('email', $request->email)->where('is_active', true)->first();

        if(!$user) return redirect()->back()->with('message', 'Your account is not verified');

    	if(Auth::attempt($data)) {
            return redirect()->back();
    	} else {
    		return redirect()->back()->with('message', 'Invalid Credentials');
    	}
    }

    public function register(RegisterAccount $request)
    {   
    	$data = $request->except(['confirm_password']);

    	$data['password'] = bcrypt($data['password']);

    	$create = User::forceCreate($data);

    	if($create) {
            if(!!$create->is_active && $create->perspective == 3) {
                Auth::login($user);
            } 
    	}

        return redirect()->back()->with('errors');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->back();
    }
} 
