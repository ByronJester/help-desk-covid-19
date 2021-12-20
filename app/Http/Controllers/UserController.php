<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\RegisterAccount;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use App\Mail\PasswordMail;
use Illuminate\Support\Facades\Mail;

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
        $id = $request->id;
        $password = null;

        if($request->password && $request->confirm_password)  {
            $data = $request->except(['confirm_password']);

            $data['password'] = bcrypt($data['password']);
        } else {
            if(!$id) {
                $password = Str::random(10);

                $data['password'] = bcrypt($password);

                $emailData = [
                    "name" => $request->first_name . " " . $request->last_name,
                    "password" => $password
                ];

                Mail::to($request->email)->send(new PasswordMail($emailData));
            }
        }

        if($image = $request->identification_image) {
            
            $path = public_path().'/images/identifications';

            $filename = time() . '_' . Str::random(8);

            $extension = $image->getClientOriginalExtension();
            
            $uplaod = $image->move($path, $filename . '.' . $extension);

            $data['identification_image'] = $filename . '.' . $extension;
        }

        $save = User::updateOrCreate(
            ['id' => $id],
            $data
        );
        
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

        $users = User::where('id', '!=', $user->id)->orderBy('updated_at', 'desc');

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
        $user = null;

        if($id != 'add') {
            $user = User::where('id', $id)->first(); 
        }
        
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

    public function viewTerms()
    {
        $user = null;

        if(Auth::user()) {
            $user = Auth::user();
        }


        return Inertia::render('Users/TermsAndCondition',
            [
                'options'    => [
                    'user'      => $user,
                ]
            ]
        );
    }
} 
