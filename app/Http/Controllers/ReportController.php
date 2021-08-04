<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Place;
use App\Models\VirusCase;

class ReportController extends Controller
{
    public function reportView(Request $request)
    {
        $user = null;

        if(Auth::user()) {
        	$user = Auth::user();
        }
        
    	return Inertia::render('Report', 
    		[
                'options'    => [
                	'user' => $user,
                    'places' => Place::orderBy('name')->get()
                ]
            ]
    	);
    }

    public function viewPlace(Request $request, $id) 
    {
        $user = null;

        if(Auth::user()) {
            $user = Auth::user();
        }

        return Inertia::render('Reports/ViewPlace', 
            [
                'options'    => [
                    'user'   => $user,
                    'places' => Place::orderBy('name')->get(),
                    'cases'  => VirusCase::orderBy('created_at', 'desc')->where('place_id', $id)->get(),
                    'id'     => $id
                ]
            ]
        );
    }
    
} 
