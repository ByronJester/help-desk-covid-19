<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Place;
use App\Models\ContactTracing;
use App\Models\VirusCase;

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

      $tracings = ContactTracing::orderBy('created_at', 'desc')
       ->where('is_active', true)->where('place_id', $place);

      if($user) {
        if($user->perspective != 1) {
          $tracings = $tracings->where('is_active', true);
        }
      } else {
        $tracings = $tracings->where('is_active', true);
      }

      if(!!$search && $search != ''){
        $tracings = $tracings->where('name', 'LIKE', '%' . $search . '%');
      }
      
      return Inertia::render('ContactTracings',
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

    public function tracingView(Request $request, $id)
    {
      $user = null;

      if(Auth::user()) {
          $user = Auth::user();
      }

      $tracing = null;

      if($id != 'add') {
        $tracing = ContactTracing::where('id', $id)->first();
      }

      return Inertia::render('ContactTracings/Save',
        [
          'options'    => [
              'user'        => $user,
              'tracing'     => $tracing,
              'place'       => $request->place
          ]
        ]
      );
    }

    public function saveTrace(Request $request)
    {
      $id = $request->id;

      $data = $request->except(['id']);

      if($id) {
        ContactTracing::where('id', $id)->update($data);
      } else {
        ContactTracing::create($data);
      }

      return redirect()->route('view.contact.tracing');
    }
}
