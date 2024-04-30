<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $mettings = Meeting::all();
            return response()->json([
                'status' => true,
                'message' => 'Toutes les salles de reunions reservables',
                'data' => $mettings
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
    public function store(Request $request)
    {
       // if (User::find(Auth::user()->id)->can('be admin')){
        if(Auth::user()->status == 'admin'){
            Validator::make($request->all(), [
                'name' =>['required'],
                'price' =>['required', 'integer'],
                'localisation' =>['required'],
                'capacity' =>['required', 'integer'],
                'equipments' =>['nullable'],
                'services' =>['nullable'],
            ])->validate();
    
            $metting = Meeting::create([
                'name' =>$request->name,
                'area' =>$request->area,
                'price' =>$request->price,
                'localisation' =>$request->localisation,
                'capacity' =>$request->capacity,
                'equipments' =>$request->equipments ? $request->equipments : null,
                'services' =>$request->services ? $request->services : null,
            ]);
    
            return response()->json([
                'status' => true,
                'message' => "Votre nouveau lieu de reunion a bien été ajoutée!",
                'data' => $metting
            ], 200);
        } else{
            return response()->json([
                'status' => true,
                'message' => "Vous n'avez pas les droits necessaires pour acceder à cette route",   
            ]);
        }
       
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
    public function update(Request $request, string $id)
    {
        //if (User::find(Auth::user()->id)->can('be admin')){
        if(Auth::user()->status == 'admin'){
            Validator::make($request->all(), [
                'name' =>['required'],
                'area' =>['required'],
                'price' =>['required', 'integer'],
                'localisation' =>['required'],
                'capacity' =>['required', 'integer'],
                'equipments' =>['nullable'],
                'services' =>['nullable'],
            ])->validate();
    
            $metting = Meeting::findOrFail($id);
            $metting->update([
                'name' =>$request->name,
                'area' =>$request->area,
                'price' =>$request->price,
                'localisation' =>$request->localisation,
                'capacity' =>$request->capacity,
                'equipments' =>$request->equipments,
                'services' =>$request->services,
            ]);
    
            return response()->json([
                'status' => true,
                'message' => "Le lieu de reunion a bien été modifiée!",
                'product' => $metting
            ], 200);
        }else{
            return response()->json([
                'status' => true,
                'message' => "Vous n'avez pas les droits necessaires pour acceder à cette route",   
            ]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //if (User::find(Auth::user()->id)->can('be admin')){
            if(Auth::user()->status == 'admin'){
            $metting = Meeting::findOrFail($id);
            $metting->delete();
            return response()->json([
                'status' => true,
                'message' => "Ce lieu a bien été supprimée!",   
            ]);
        }else{
            return response()->json([
                'status' => true,
                'message' => "Vous n'avez pas les droits necessaires pour acceder à cette route",   
            ]);
        }
       
    }

    public function delete(string $id)
    {
       // if (User::find(Auth::user()->id)->can('be admin')){
        if(Auth::user()->status == 'admin'){
            $metting = Meeting::findOrFail($id);
            $metting->blocked = true;
            $metting->save();
            return response()->json([
                'status' => true,
                'message' => "Ce lieu a bien été supprimée!",   
            ]);
        }else{
            return response()->json([
                'status' => true,
                'message' => "Vous n'avez pas les droits necessaires pour acceder à cette route",   
            ]);
        }  
    }

    public function blockeduser(string $iduser)
    {
        //if (User::find(Auth::user()->id)->can('be admin')){
            if(Auth::user()->status == 'admin'){
            $user = User::findOrFail($iduser);
            $user->blocked = true;
            $user->save();
            return response()->json([
                'status' => true,
                'message' => "Ce lieu a bien été supprimée!",   
            ]);
        }else{
            return response()->json([
                'status' => true,
                'message' => "Vous n'avez pas les droits necessaires pour acceder à cette route",   
            ]);
        }
       
    }

    public function indexmeet()
    {
        //if (User::find(Auth::user()->id)->can('be admin')){
            if(Auth::user()->status == 'admin'){
            $reservations = Reservation::all();
            return response()->json([
                'status' => true,
                'message' => "",   
                'data' => $reservations
            ]);
        } else{
            return response()->json([
                'status' => true,
                'message' => "Vous n'avez pas les droits necessaires pour acceder à cette route",   
            ]);
        }    
    }
}
