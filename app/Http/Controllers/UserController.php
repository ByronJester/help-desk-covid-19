<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{

	#Login User
    public function login(Request $request)
    {
    	$data = [
    		'email' => $request->email,
    		'password' => $request->password,
    	];

    	if(Auth::attempt($data)) {
    		$user = User::where('email', $request->email)->first();
    		Auth::login($user);
    		
    		return redirect()->route('view.home');
    	} else {
    		return response()->json(['message' => 'Error Login']);
    	}
    }

    public function register(Request $request)
    {
    	$data = $request->except(['confirm_password']);

    	$data['password'] = bcrypt($data['password']);

    	$create = User::forceCreate($data);

    	if($create) {
    		return redirect('/home');
    	}
    }
} 
