<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function research(string $id_metting, Request $request){
        Validator::make($request->all(), [
            'date' =>['required'],
            'time' =>['required'],
        ])->validate();

        $available = Reservation::where('meeting_id',$id_metting)->where('date',$request->date)->where('time',$request->time)->first();

            return response()->json([
                'status' => true,
                'message' => $available ? "Cette salle de reunion est bien disponible pour vous" : "Cette salle est deja reservé",
            ], 200); 
    }

    public function myMetting(){
        $mymettings = Reservation::where('user_id',Auth::user()->id)->get();
        return response()->json([
            'status' => true,
            'message' => "",
            'data' => $mymettings
        ], 200);
    }

    public function domeeting(string $id_metting, Request $request){
        Validator::make($request->all(), [
            'date' =>['required'],
            'time' =>['required'],
        ])->validate();

        $available = Reservation::where('meeting_id',$id_metting)->where('date',$request->date)->where('time',$request->time)->first();
        if (!$available) {
            $reservation = Reservation::create([
                'meeting_id' =>$id_metting,
                'user_id' =>Auth::user()->id,
                'date' =>$request->date,
                'time' =>$request->time,
            ]);

            return response()->json([
                'status' => true,
                'message' => "La reservation a été faite",
                'data'=>  $reservation
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Cette salle est deja reservé",
            ], 200);
        }
    }

    public function cancelmeeting(string $id_metting, Request $request){
        Validator::make($request->all(), [
            'date' =>['required'],
            'time' =>['required'],
        ])->validate();
 
        $available = Reservation::where('user_id',Auth::user()->id)->where('meeting_id',$id_metting)->where('date',$request->date)->where('time',$request->time)->first();
        if ($available) {
            $available->delete();
            return response()->json([
                'status' => true,
                'message' => "La reservation a été annulée",
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Vous n'avez pas fait cette reservation",
            ], 200);
        }
    }
}
