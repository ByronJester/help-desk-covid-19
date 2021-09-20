<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Vaccination;
use App\Models\Place;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\SaveVaccination;

class VaccinationController extends Controller
{
    public function vaccinationList(Request $request)
    {
    	$user = null;

        if(Auth::user()) {
            $user = Auth::user(); 
        }

        $perPage = $request->perPage ?? 10;
        $page = $request->page ?? 1; 

        $search = $request->search ?? '';

        $places = Place::get();

        $place = $request->place ?? $places[0]['id'];

        $vaccinations = Vaccination::orderBy('created_at', 'desc')->where('place_id', $place);

        if(!!$search && $search != ''){
        	$vaccinations = $vaccinations->where('name', 'LIKE', '%' . $search . '%');
        }
        
        return Inertia::render('Vaccinations',
            [
                'options'    => [
                    'user'      	=> $user,
                    'vaccinations'  => $vaccinations->paginate($perPage),
                    'places'    	=> $places,
                    'place'			=> $place,
                    'search'        => $search
                ]
            ]
        );
    }

    public function saveVaccination(SaveVaccination $request)
    {
        $save = Vaccination::create($request->toArray());

        return redirect()->back();
    }

    public function approveVaccination(Request $request)
    {

    }
}
