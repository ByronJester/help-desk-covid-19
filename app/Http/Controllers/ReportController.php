<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Place;
use App\Models\VirusCase;
use App\Models\Vaccine;
use App\Models\Vaccination;
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

        $vaccines = Vaccine::get();

        $vaccinations = [];

        foreach ($vaccines as $vaccine) {
            $vaccine = (object) $vaccine;

            $vaccinations[] = [
                'name'     => $vaccine->name,
                'male'     => Vaccination::where('vaccine_id', $vaccine->id)->where('gender', 'MALE')->count(),
                'female'   => Vaccination::where('vaccine_id', $vaccine->id)->where('gender', 'FEMALE')->count(),
                'A1'       => Vaccination::where('vaccine_id', $vaccine->id)->where('classification', 'A1')->count(),
                'A2'       => Vaccination::where('vaccine_id', $vaccine->id)->where('classification', 'A2')->count(),
                'A3'       => Vaccination::where('vaccine_id', $vaccine->id)->where('classification', 'A3')->count(),
                'A4'       => Vaccination::where('vaccine_id', $vaccine->id)->where('classification', 'A4')->count(),
                'A5'       => Vaccination::where('vaccine_id', $vaccine->id)->where('classification', 'A5')->count(),
                'B1'       => Vaccination::where('vaccine_id', $vaccine->id)->where('classification', 'B1')->count(),
                'B2'       => Vaccination::where('vaccine_id', $vaccine->id)->where('classification', 'B2')->count(),
                'B3'       => Vaccination::where('vaccine_id', $vaccine->id)->where('classification', 'B3')->count(),
                'B4'       => Vaccination::where('vaccine_id', $vaccine->id)->where('classification', 'B4')->count(),
                'B5'       => Vaccination::where('vaccine_id', $vaccine->id)->where('classification', 'B5')->count(),
                'B6'       => Vaccination::where('vaccine_id', $vaccine->id)->where('classification', 'B6')->count(),
                'C'        => Vaccination::where('vaccine_id', $vaccine->id)->where('classification', 'C')->count(),

            ];
        }
        
    	return Inertia::render('Report', 
    		[
                'options'    => [
                	'user'      => $user,
                    'places'    => Place::orderBy('name')->get(),
                    'vaccines'  => $vaccines,
                    'records'   => [
                        'recovered'     => $recovered,
                        'death'         => $death,
                        'quarantine'    => $quarantine,
                        'male'          => $male,
                        'female'        => $female,
                    ],
                    'vaccinations'       => $vaccinations,
                    "pendingVaccination" => [],
                    "finishVaccination"  => []
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

        $vaccines = Vaccine::get();

        $vaccinations = [];

        foreach ($vaccines as $vaccine) {
            $vaccine = (object) $vaccine;

            $vaccinations[] = [
                'name'     => $vaccine->name,
                'male'     => Vaccination::where('vaccine_id', $vaccine->id)->where('place_id', $id)
                               ->where('gender', 'MALE')->count(),
                'female'   => Vaccination::where('vaccine_id', $vaccine->id)->where('place_id', $id)
                            ->where('gender', 'FEMALE')->count(),
                'A1'       => Vaccination::where('vaccine_id', $vaccine->id)
                                ->where('place_id', $id)->where('classification', 'A1')->count(),
                'A2'       => Vaccination::where('vaccine_id', $vaccine->id)
                                ->where('place_id', $id)->where('classification', 'A2')->count(),
                'A3'       => Vaccination::where('vaccine_id', $vaccine->id)
                                ->where('place_id', $id)->where('classification', 'A3')->count(),
                'A4'       => Vaccination::where('vaccine_id', $vaccine->id)
                                ->where('place_id', $id)->where('classification', 'A4')->count(),
                'A5'       => Vaccination::where('vaccine_id', $vaccine->id)
                                ->where('place_id', $id)->where('classification', 'A5')->count(),
                'B1'       => Vaccination::where('vaccine_id', $vaccine->id)
                                ->where('place_id', $id)->where('classification', 'B1')->count(),
                'B2'       => Vaccination::where('vaccine_id', $vaccine->id)
                                ->where('place_id', $id)->where('classification', 'B2')->count(),
                'B3'       => Vaccination::where('vaccine_id', $vaccine->id)
                                ->where('place_id', $id)->where('classification', 'B3')->count(),
                'B4'       => Vaccination::where('vaccine_id', $vaccine->id)
                                ->where('place_id', $id)->where('classification', 'B4')->count(),
                'B5'       => Vaccination::where('vaccine_id', $vaccine->id)
                                ->where('place_id', $id)->where('classification', 'B5')->count(),
                'B6'       => Vaccination::where('vaccine_id', $vaccine->id)
                                ->where('place_id', $id)->where('classification', 'B6')->count(),
                'C'        => Vaccination::where('vaccine_id', $vaccine->id)
                                ->where('place_id', $id)->where('classification', 'C')->count(),
            ];
        }

        return Inertia::render('Reports/ViewPlace', 
            [
                'options'    => [
                    'user'   => $user,
                    'place'  => Place::where('id', $id)->first(),
                    'cases'  => VirusCase::orderBy('created_at', 'desc')->where('place_id', $id)->get(),
                    'vaccines'  => $vaccines,
                    'records'   => [
                        'recovered'     => $recovered,
                        'death'         => $death,
                        'quarantine'    => $quarantine,
                        'male'          => $male,
                        'female'        => $female,
                    ],
                    "vaccinations" => $vaccinations
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
