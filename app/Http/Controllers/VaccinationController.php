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
use Illuminate\Support\Facades\Route;

class VaccinationController extends Controller
{
    public function vaccinationList(Request $request)
    {
    	$user = null;

        if(Auth::user()) {
            $user = Auth::user(); 
        }

        $uri = $request->path();

        $perPage = $request->perPage ?? 10;
        $page = $request->page ?? 1; 

        $search = $request->search ?? '';

        $places = Place::get();

        $place = $request->place ?? $places[0]['id'];

        $vaccinations = Vaccination::orderBy('created_at', 'desc');

        if($user) {
            if($user->perspective != 1) {
                $vaccinations = $vaccinations->where('is_active', true);
            }
        } else {
            $vaccinations = $vaccinations->where('is_active', true);
        }

        if(!!$search && $search != ''){
        	$vaccinations = $vaccinations->where('name', 'LIKE', '%' . $search . '%');
        }

        if($uri == 'reports/pending-vaccination') {
            $vaccinations = $vaccinations->where(function ($q) {
                $q->orWhere('status', 'pending')->orWhere('status', 'approve');
            });
        }

        if($uri == 'reports/finish-vaccination') {
            $vaccinations = $vaccinations->where('status', 'finish');
        }
        
        return Inertia::render('Vaccinations',
            [
                'options'    => [
                    'user'      	=> $user,
                    'vaccinations'  => $vaccinations->paginate($perPage),
                    'places'    	=> $places,
                    'place'			=> $place,
                    'search'        => $search,
                    'uri'           => $uri
                ]
            ]
        );
    }

    public function saveVaccination(SaveVaccination $request)
    {
        $save = Vaccination::create($request->except(['vaccine_id']));

        return redirect()->back();
    }

    public function changeStatus(Request $request)
    {
        if($request->status == 'archive') {
            $update = Vaccination::where('id', $request->id)->update(['is_active' => false]);
        } else if($request->status == 'recover') {
            $update = Vaccination::where('id', $request->id)->update(['is_active' => true]);
        } else {
            $update = Vaccination::where('id', $request->id)->update(['status' => $request->status]);
        }
        
        return redirect()->back();
    }
}
