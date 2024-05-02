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
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function indexusers()
    {
        $users = User::all();
        return response()->json([
            'status' => true,
            'message' => 'Voici la liste de tous vos employés',
            'data' => $users
        ]);
    }

    public function allVols()
    {
        $allVols = ReservationVol::all();
        return response()->json([
            'status' => true,
            'message' => 'Voici la listes de tous vos employés',
            'data' => $allVols
        ]);
    }

    public function allhebergement()
    {
        $allhebergement = ReservationHebergement::all();
        return response()->json([
            'status' => true,
            'message' => 'Voici la listes de tous vos employés',
            'data' => $allhebergement
        ]);
    }

    public function allactivities()
    {
        $allactivities = ReservationActivity::all();
        return response()->json([
            'status' => true,
            'message' => 'Voici la listes de tous vos employés',
            'data' => $allactivities
        ]);
    }

    public function responsevol(string $id,Request $request)
    {
        $leave = ReservationVol::find($id);
        $leave->status = $request->status ? $request->status : $leave->status;
        $leave->save();
        return response()->json([
            'status' => true,
            'message' => 'Voici la listes de tous vos employés',
            'data' => $leave
        ]);
    }

    public function responsehebergement(string $id,Request $request)
    {
        $leave = ReservationHebergement::find($id);
        $leave->status = $request->status ? $request->status : $leave->status;
        $leave->save();
        return response()->json([
            'status' => true,
            'message' => 'Voici la listes de tous vos employés',
            'data' => $leave
        ]);
    }

    public function responseactivity(string $id,Request $request)
    {
        $leave = ReservationActivity::find($id);
        $leave->status = $request->status ? $request->status : $leave->status;
        $leave->save();
        return response()->json([
            'status' => true,
            'message' => 'Voici la listes de tous vos employés',
            'data' => $leave
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storevol(Request $request)
    {
        Validator::make($request->all(), [
            'company' =>['required'],
            'airport_start' =>['required'],
            'airport_end' =>['required'],
            'date_start' =>['required'],
            'date_end' =>['required'],
            'places' =>['required'],
            'price' =>['required'],
        ]);

        $department = Vol::create([
            'company' =>$request->company,
            'airport_start' =>$request->airport_start,
            'airport_end' =>$request->airport_end,
            'volStart' =>$request->date_start,
            'volEnd' =>$request->date_end,
            'places' =>$request->places,
            'price' =>$request->price,
        
        ]);

        return response()->json([
            'status' => true,
            'message' => "Un nouveau departement a bien été créee!",
            'data' => $department
        ], 200);
    }

    public function storehebergement( Request $request)
    {
        Validator::make($request->all(), [
            'name' =>['required'],
            'localisation' =>['required'],
            'type' =>['required'],
            'places' =>['required', 'integer'],
            'price' =>['required', 'integer'],
        ]);

        $department = Hebergement::create([
            'name' =>$request->name,
            'localisation' =>$request->localisation,
            'type' =>$request->type,
            'places' =>$request->places,
            'price' =>$request->price,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Une nouvelle paie de salaire a bien été créee!",
            'data' => $department
        ], 200);
    }

    public function storeactivity(Request $request)
    {
        Validator::make($request->all(), [
            'name' =>['required'],
            'localisation' =>['required'],
            'type' =>['required'],
            'duration' =>['required'],
            'date' =>['required'],
            'price' =>['required', 'integer'],
        ]);

        $department = Activity::create([
            'name' =>$request->name,
            'localisation' =>$request->localisation,
            'type' =>$request->type,
            'duration' =>$request->duration,
            'price' =>$request->price,
            'date' =>$request->date,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Une nouvelle affectation a bien été créee!",
            'data' => $department
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatevol(Request $request, string $id)
    {
        Validator::make($request->all(), [
            'company' =>['required'],
            'airport_start' =>['required'],
            'airport_end' =>['required'],
            'date_start' =>['required'],
            'date_end' =>['required'],
            'places' =>['required'],
            'price' =>['required'],
        ]);

        $department = Vol::find($id);
        $department = $department->update([
            'company' =>$request->company,
            'airport_start' =>$request->airport_start,
            'airport_end' =>$request->airport_end,
            'volStart' =>$request->date_start,
            'volEnd' =>$request->date_end,
            'places' =>$request->places,
            'price' =>$request->price,
        
        ]);

        return response()->json([
            'status' => true,
            'message' => "Ce departement a bien été mise à jour!",
            'data' => $department
        ], 200);
    }

    public function updatehebergement(Request $request, string $id)
    {
        Validator::make($request->all(), [
            'name' =>['required'],
            'localisation' =>['required'],
            'type' =>['required'],
            'places' =>['required', 'integer'],
            'price' =>['required', 'integer'],
        ]);

        $salary = Hebergement::find($id);
        $department = $salary->update([
            'name' =>$request->name,
            'localisation' =>$request->localisation,
            'type' =>$request->type,
            'places' =>$request->places,
            'price' =>$request->price,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Une nouvelle paie de salaire a bien été mise à jour!",
            'data' => $department
        ], 200);
    }

    public function updateactivity(Request $request, string $id)
    {
        Validator::make($request->all(), [
            'name' =>['required'],
            'localisation' =>['required'],
            'type' =>['required'],
            'duration' =>['required'],
            'date' =>['required'],
            'price' =>['required', 'integer'],
        ]);

        $history = Activity::find($id);
        $department = $history->update([
            'name' =>$request->name,
            'localisation' =>$request->localisation,
            'type' =>$request->type,
            'duration' =>$request->duration,
            'price' =>$request->price,
            'date' =>$request->date,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Une nouvelle affectation a bien été créee!",
            'data' => $department
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
