<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function homeView()
    {
        $user = null;

        if(Auth::user()) {
        	$user = Auth::user();
        }
        
    	return Inertia::render('Home', 
    		[
                'options'    => [
                	'user' => $user
                ]
            ]
    	);
    }
    
} 
