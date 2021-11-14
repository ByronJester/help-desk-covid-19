<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Place;
use App\Models\ContactTracing;

class ContactTracingController extends Controller
{
    public function traceList(Request $request)
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

      $tracings = ContactTracing::orderBy('created_at', 'desc')->where('place_id', $place);

      if(!!$search && $search != ''){
        $tracings = $tracings->where('name', 'LIKE', '%' . $search . '%');
      }
      
      return Inertia::render('ContactTracing',
          [
              'options'    => [
                  'user'        => $user,
                  'places'      => $places,
                  'place'       => $place,
                  'search'      => $search,
                  'tracings'    => $tracings->paginate($perPage)
              ]
          ]
      );
    
    }
}
