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

        $recovered  = VirusCase::where('is_active', true)->where('status', 'RECOVERED')->count();
        $death      = VirusCase::where('is_active', true)->where('status', 'DEATH')->count();
        $quarantine = VirusCase::where('is_active', true)->where('status', 'QUARANTINE')->count();
        $male       = VirusCase::where('is_active', true)->where('gender', 'MALE')->count();
        $female     = VirusCase::where('is_active', true)->where('gender', 'FEMALE')->count();

        $vaccines = Vaccine::get();

        // $vaccinations = [];

        // foreach ($vaccines as $vaccine) {
        //     $vaccine = (object) $vaccine;

            // $vaccinations[] = [
            //     'name'     => $vaccine->name,
            //     'male'     => Vaccination::where('is_active', true)->where('gender', 'MALE')->count(),
            //     'female'   => Vaccination::where('is_active', true)->where('gender', 'FEMALE')->count(),
            //     'A1'       => Vaccination::where('is_active', true)->where('classification', 'A1')->count(),
            //     'A2'       => Vaccination::where('is_active', true)->where('classification', 'A2')->count(),
            //     'A3'       => Vaccination::where('is_active', true)->where('classification', 'A3')->count(),
            //     'A4'       => Vaccination::where('is_active', true)->where('classification', 'A4')->count(),
            //     'A5'       => Vaccination::where('is_active', true)->where('classification', 'A5')->count(),
            //     'B1'       => Vaccination::where('is_active', true)->where('classification', 'B1')->count(),
            //     'B2'       => Vaccination::where('is_active', true)->where('classification', 'B2')->count(),
            //     'B3'       => Vaccination::where('is_active', true)->where('classification', 'B3')->count(),
            //     'B4'       => Vaccination::where('is_active', true)->where('classification', 'B4')->count(),
            //     'B5'       => Vaccination::where('is_active', true)->where('classification', 'B5')->count(),
            //     'B6'       => Vaccination::where('is_active', true)->where('classification', 'B6')->count(),
            //     'C'        => Vaccination::where('is_active', true)->where('classification', 'C')->count(),

            // ];
        // }
        
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
                    'vaccinations'       => [],
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

        $recovered  = VirusCase::where('is_active', true)->where('status', 'RECOVERED')->where('place_id', $id)->count();
        $death      = VirusCase::where('is_active', true)->where('status', 'DEATH')->where('place_id', $id)->count();
        $quarantine = VirusCase::where('is_active', true)->where('status', 'QUARANTINE')->where('place_id', $id)->count();
        $male       = VirusCase::where('is_active', true)->where('gender', 'MALE')->where('place_id', $id)->count();
        $female     = VirusCase::where('is_active', true)->where('gender', 'FEMALE')->where('place_id', $id)->count();

        $vaccines = Vaccine::get();

        // $vaccinations = [];

        // foreach ($vaccines as $vaccine) {
        //     $vaccine = (object) $vaccine;

        //     $vaccinations[] = [
        //         'name'     => $vaccine->name,
        //         'male'     => Vaccination::where('is_active', true)->where('vaccine_id', $vaccine->id)->where('place_id', $id)
        //                        ->where('gender', 'MALE')->count(),
        //         'female'   => Vaccination::where('is_active', true)->where('vaccine_id', $vaccine->id)->where('place_id', $id)
        //                     ->where('gender', 'FEMALE')->count(),
        //         'A1'       => Vaccination::where('is_active', true)->where('vaccine_id', $vaccine->id)
        //                         ->where('place_id', $id)->where('classification', 'A1')->count(),
        //         'A2'       => Vaccination::where('is_active', true)->where('vaccine_id', $vaccine->id)
        //                         ->where('place_id', $id)->where('classification', 'A2')->count(),
        //         'A3'       => Vaccination::where('is_active', true)->where('vaccine_id', $vaccine->id)
        //                         ->where('place_id', $id)->where('classification', 'A3')->count(),
        //         'A4'       => Vaccination::where('is_active', true)->where('vaccine_id', $vaccine->id)
        //                         ->where('place_id', $id)->where('classification', 'A4')->count(),
        //         'A5'       => Vaccination::where('is_active', true)->where('vaccine_id', $vaccine->id)
        //                         ->where('place_id', $id)->where('classification', 'A5')->count(),
        //         'B1'       => Vaccination::where('is_active', true)->where('vaccine_id', $vaccine->id)
        //                         ->where('place_id', $id)->where('classification', 'B1')->count(),
        //         'B2'       => Vaccination::where('is_active', true)->where('vaccine_id', $vaccine->id)
        //                         ->where('place_id', $id)->where('classification', 'B2')->count(),
        //         'B3'       => Vaccination::where('is_active', true)->where('vaccine_id', $vaccine->id)
        //                         ->where('place_id', $id)->where('classification', 'B3')->count(),
        //         'B4'       => Vaccination::where('is_active', true)->where('vaccine_id', $vaccine->id)
        //                         ->where('place_id', $id)->where('classification', 'B4')->count(),
        //         'B5'       => Vaccination::where('is_active', true)->where('vaccine_id', $vaccine->id)
        //                         ->where('place_id', $id)->where('classification', 'B5')->count(),
        //         'B6'       => Vaccination::where('is_active', true)->where('vaccine_id', $vaccine->id)
        //                         ->where('place_id', $id)->where('classification', 'B6')->count(),
        //         'C'        => Vaccination::where('is_active', true)->where('vaccine_id', $vaccine->id)
        //                         ->where('place_id', $id)->where('classification', 'C')->count(),
        //     ];
        // }

        return Inertia::render('Reports/ViewPlace', 
            [
                'options'    => [
                    'user'   => $user,
                    'place'  => Place::where('id', $id)->first(),
                    'cases'  => VirusCase::orderBy('updated_at', 'desc')->where('is_active', true)->where('place_id', $id)->get(),
                    'vaccines'  => $vaccines,
                    'records'   => [
                        'recovered'     => $recovered,
                        'death'         => $death,
                        'quarantine'    => $quarantine,
                        'male'          => $male,
                        'female'        => $female,
                    ],
                    "vaccinations" => []
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
