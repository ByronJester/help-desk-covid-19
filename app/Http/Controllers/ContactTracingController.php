<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Place;
use App\Models\ContactTracing;
use App\Models\VirusCase;
use Nexmo\Laravel\Facade\Nexmo;

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

      $place = Place::where('id', $request->place_id)->first();

      if($id) {
        ContactTracing::where('id', $id)->update($data);
      } else {
        ContactTracing::create($data);
      }

      Nexmo::message()->send([
        'to'    => $place->contact,
        'from'  => '639557347496',
        'text'  => $request->name . ' is a new contact tracing patient in ' . $place->name
      ]);

      return redirect()->route('view.contact.tracing');
    }

    public function changeStatus(Request $request)
    {
      $id = $request->id;

      $data = $request->only(['is_active']);

      ContactTracing::where('id', $id)->update($data);

      return redirect()->route('view.contact.tracing');
    }
}
