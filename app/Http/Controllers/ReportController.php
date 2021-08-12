<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Place;
use App\Models\VirusCase;
use App\Http\Requests\VirusCase as SaveCase;

class ReportController extends Controller
{
    public function reportView(Request $request)
    {
        $user = null;

        if(Auth::user()) {
        	$user = Auth::user();
        }

        $recovered  = VirusCase::where('status', 'RECOVERED')->count();
        $death      = VirusCase::where('status', 'DEATH')->count();
        $quarantine = VirusCase::where('status', 'QUARANTINE')->count();
        $male       = VirusCase::where('gender', 'MALE')->count();
        $female     = VirusCase::where('gender', 'FEMALE')->count();
        
    	return Inertia::render('Report', 
    		[
                'options'    => [
                	'user'      => $user,
                    'places'    => Place::orderBy('name')->get(),
                    'records'   => [
                        'recovered'     => $recovered,
                        'death'         => $death,
                        'quarantine'    => $quarantine,
                        'male'          => $male,
                        'female'        => $female,
                    ]
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

        $recovered  = VirusCase::where('status', 'RECOVERED')->where('place_id', $id)->count();
        $death      = VirusCase::where('status', 'DEATH')->where('place_id', $id)->count();
        $quarantine = VirusCase::where('status', 'QUARANTINE')->where('place_id', $id)->count();
        $male       = VirusCase::where('gender', 'MALE')->where('place_id', $id)->count();
        $female     = VirusCase::where('gender', 'FEMALE')->where('place_id', $id)->count();

        return Inertia::render('Reports/ViewPlace', 
            [
                'options'    => [
                    'user'   => $user,
                    'place'  => Place::where('id', $id)->first(),
                    'cases'  => VirusCase::orderBy('created_at', 'desc')->where('place_id', $id)->get(),
                    'records'   => [
                        'recovered'     => $recovered,
                        'death'         => $death,
                        'quarantine'    => $quarantine,
                        'male'          => $male,
                        'female'        => $female,
                    ]
                ]
            ]
        );
    }

    public function savePlaceIncident(SaveCase $request)
    {
        $create = VirusCase::updateOrCreate(
            ['id' => $request->id],
            $request->except(['id'])
        );

        return redirect()->route('view.place.incident', $request->place_id);
    }
    
} 
