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
use Nexmo\Laravel\Facade\Nexmo;

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

        if($user) {
          if($user->perspective != 1) {
            $cases = $cases->where('is_active', true);
          }
        } else {
          $cases = $cases->where('is_active', true);
        }

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

      $id = null;
      $case = null;

      if(!$request->id) {
        $id = $create->id;
        $case = VirusCase::where('id', $create->id)->first();
        $place = (object) $case->place;

        // Nexmo::message()->send([
        //   'to'    => $place->contact,
        //   'from'  => '639557347496',
        //   'text'  => 'Your barangay has new covid case with patient code ' . $case->code
        // ]);
      }

      return redirect()->back();
    }

    public function changeStatus(Request $request)
    {
      $id = $request->id;

      $data = $request->only(['is_active']);

      VirusCase::where('id', $id)->update($data);

      return response()->json(['message' => 'Successfully change status.']);
    }

}
