<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\RegisterAccount;
use Illuminate\Database\Eloquent\Builder;

class UserController extends Controller
{

    public function login(Request $request)
    {
    	$data = [
    		'email' => $request->email,
    		'password' => $request->password,
    	];

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return redirect()->back()->with('message', 'No account found.');
        }

        if(!$user->is_active) {
            return redirect()->back()->with('message', 'Your account is not verified.');
        }

    	if(Auth::attempt($data)) {
            return redirect()->back();
    	} else {
    		return redirect()->back()->with('message', 'Invalid Credentials.');
    	}
    }

    public function saveUser(RegisterAccount $request)
    { 
        $data = $request->toArray();

        if($request->password && $request->confirm_password)  {
            $data = $request->except(['confirm_password']);

            $data['password'] = bcrypt($data['password']);
        }

    	// $create = User::forceCreate($data);

        $save = User::updateOrCreate(
            ['id' => $request->id],
            $data
        );

    	if($save) {
            if(!!$save->is_active && $save->perspective == 3) {
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

    public function usersView(Request $request)
    {
        $user = null;

        if(Auth::user()) {
            $user = Auth::user();
        }

        $perPage = $request->perPage ?? 5; 
        $page = $request->page ?? 1;

        $search = $request->search ?? null;

        $users = User::where('perspective', $user->perspective)->where('id', '!=', $user->id);

        if(!!$search && $search != '') {
            $users = $users->where(function (Builder $query) use ($search) {
                return $query->where('first_name', 'LIKE', '%' . $search . '%')
                    ->where('middle_name', 'LIKE', '%' . $search . '%')
                    ->where('last_name', 'LIKE', '%' . $search . '%');
            });
        }
        
        return Inertia::render('Users',
            [
                'options'    => [
                    'user'      => $user,
                    'users'     => $users->paginate($perPage)
                ]
            ]
        );
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $auth = null;

        if(Auth::user()) {
            $auth = Auth::user();
        }

        return Inertia::render('Users/SaveUser',
            [
                'options'    => [
                    'user'      => $user,
                    'auth'      => $auth
                ]
            ]
        );
    }
} 
