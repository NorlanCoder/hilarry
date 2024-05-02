<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Hebergement;
use App\Models\ReservationActivity;
use App\Models\ReservationHebergement;
use App\Models\ReservationVol;
use App\Models\User;
use App\Models\Vol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /*public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['searchVol','searchHebergement','searchActivity','indexVols','indexactivities','indexhebergements']]);
    }*/

    public function searchVol(Request $request)
    {
        $airport_start = $request->airport_start;
        $airport_end = $request->airport_end;
        $date_start = $request->date_start;
        $places = $request->places;
    
        $query = Vol::query();
    
        if (!is_null($airport_start)) {
            $query->where('airport_start', 'like', '%' . $airport_start . '%');
        }
    
        if (!is_null($date_start)) {
            $query->where('VolStart', $date_start);
        }
    
        if (!is_null($airport_end)) {
            $query->where('airport_end', 'like', '%' . $airport_end . '%');
        }

        if (!is_null($places)) {
            $query->where('places', '<=', $places );
        }
    
        $results = $query->get();
    
        return response()->json([
            'status' => true,
            'message' => "",
            'data' => $results
        ], 200);
    }

    public function searchHebergement(Request $request)
    {
        $localisation = $request->localisation;
        $type = $request->type;
        $places = $request->places;
    
        $query = Hebergement::query();
    
        if (!is_null($localisation)) {
            $query->where('localisation', 'like', '%' . $localisation . '%');
        }
    
        if (!is_null($type)) {
            $query->where('type', 'like', '%' . $type . '%');
        }

        if (!is_null($places)) {
            $query->where('places', '<=', $places );
        }
    
        $results = $query->get();
    
        return response()->json([
            'status' => true,
            'message' => "",
            'data' => $results
        ], 200);
    }

    public function searchActivity(Request $request)
    {
        $localisation = $request->localisation;
        $type = $request->type;
        $date = $request->date;
    
        $query = Activity::query();
    
        if (!is_null($localisation)) {
            $query->where('localisation', 'like', '%' . $localisation . '%');
        }
    
        if (!is_null($type)) {
            $query->where('type', 'like', '%' . $type . '%');
        }

        if (!is_null($date)) {
            $query->where('date', 'like', '%' . $date . '%');
        }
    
        $results = $query->get();
    
        return response()->json([
            'status' => true,
            'message' => "",
            'data' => $results
        ], 200);
    }

    public function reserverVol(string $id, Request $request){
        Validator::make($request->all(), [
            'places' =>['required','integer'],
        ]);
        $vol = Vol::find($id);

        $department = ReservationVol::create([
            'places' =>$request->places,
            'priceTotal' =>$request->places * $vol->price,
            'vol_id' =>$id,
            'user_id' =>Auth::user()->id,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Un nouveau departement a bien été créee!",
            'data' => $department
        ], 200);
    }

    public function reserverHebergement(string $id, Request $request){
        Validator::make($request->all(), [
            'places' =>['required','integer'],
            'date' =>['required'],
        ]);

        $hebergement = Hebergement::find($id);

        $department = ReservationHebergement::create([
            'places' =>$request->places,
            'date' =>$request->date,
            'priceTotal' =>$request->places * $hebergement->price,
            'hebergement_id' =>$id,
            'user_id' =>Auth::user()->id,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Un nouveau departement a bien été créee!",
            'data' => $department
        ], 200);
    }

    public function reserverActivity(string $id, Request $request){
        Validator::make($request->all(), [
            'places' =>['required','integer'],
        ]);

        $activity = Activity::find($id);

        $department = ReservationActivity::create([
            'places' =>$request->places,
            'date' =>$activity->date,
            'priceTotal' =>$request->places * $activity->price,
            'activity_id' =>$id,
            'user_id' =>Auth::user()->id,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Un nouveau departement a bien été créee!",
            'data' => $department
        ], 200);
    }

    public function myVol()
    {
        $myVols = ReservationVol::where('user_id', auth()->user()->id)->get();
        return response()->json([
            'status' => true,
            'message' => 'Vos informations',
            'data' => $myVols
        ]);
    }

    public function myActivities()
    {
        $myVols = ReservationActivity::where('user_id', auth()->user()->id)->get();
        return response()->json([
            'status' => true,
            'message' => 'Vos informations',
            'data' => $myVols
        ]);
    }

    public function myHebergement()
    {
        $myVols = ReservationHebergement::where('user_id', auth()->user()->id)->get();
        return response()->json([
            'status' => true,
            'message' => 'Vos informations',
            'data' => $myVols
        ]);
    }

    public function updateProfil(Request $request)
    {
        $name = $request->name;
        $country_from = $request->country_from;

        $user = User::find(Auth::user()->id);
      
        if (!is_null($name)) {
            $user->name = $name;
        }
    
        if (!is_null($country_from)) {
            $user->country_from = $country_from;
        }

        $user->save();
    
        return response()->json([
            'status' => true,
            'message' => "",
            'data' => $user
        ], 200);
    }

    public function indexVols()
    {
        $vols = Vol::all();
        return response()->json([
            'status' => true,
            'message' => 'Voici la listes de tous les departements du service',
            'data' => $vols
        ]);
    }

    public function indexactivities()
    {
        $activities = Activity::all();
        return response()->json([
            'status' => true,
            'message' => 'Voici la listes de tous vos employés',
            'data' => $activities
        ]);
    }

    public function indexhebergements()
    {
        $hebergements = Hebergement::all();
        return response()->json([
            'status' => true,
            'message' => 'Voici la listes de tous vos employés',
            'data' => $hebergements
        ]);
    }

    public function unauthorize(){
        return response()->json([
            'status' => true,
            'message' => "Vous n'avez pas les droits neccesaire pour cette action",
        ], 200);
    }
}
