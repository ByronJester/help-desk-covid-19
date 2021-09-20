<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\VirusCase;
use App\Models\Place;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\VirusCase as SaveCase;

class VirusCaseController extends Controller
{
    public function virusList(Request $request)
    {
    	$user = null;

        if(Auth::user()) {
            $user = Auth::user();
        }

        $perPage = $request->perPage ?? 10;
        $page = $request->page ?? 1; 

        $search = $request->search ?? null;

        $places = Place::get();

        $place = $request->place ?? $places[0]['id'];

        $cases = VirusCase::orderBy('created_at', 'desc')->where('place_id', $place);

        if(!!$search && $search != ''){
        	$cases = $cases->where('code', 'LIKE', '%' . $search . '%');
        }
        
        return Inertia::render('Cases',
            [
                'options'    => [
                    'user'      => $user,
                    'cases'     => $cases->paginate($perPage),
                    'places'    => $places,
                    'place'		=> $place,
                    'search'    => $search
                ]
            ]
        );
    }

    public function caseSave(SaveCase $request)
    {
  		$create = VirusCase::updateOrCreate(
          ['id' => $request->id],
          $request->except(['id'])
      );

      return redirect()->back();
    }
}
