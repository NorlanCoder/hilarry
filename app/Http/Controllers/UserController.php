<?php

namespace App\Http\Controllers;

use App\Models\EmploymentHistory;
use App\Models\Leave;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $myLeaves = Leave::where('user_id', auth()->user()->id)->get();
        return response()->json([
            'status' => true,
            'message' => 'Toutes vos demandes de congés',
            'data' => $myLeaves
        ]);
    }

    public function indexhistories()
    {
        $myLeaves = EmploymentHistory::where('user_id', auth()->user()->id)->get();
        return response()->json([
            'status' => true,
            'message' => 'TLes informations sur vos affectations',
            'data' => $myLeaves
        ]);
    }

    public function indexsalaries()
    {
        $myLeaves = Salary::where('user_id', auth()->user()->id)->get();
        return response()->json([
            'status' => true,
            'message' => 'Les informations sur vos salaires',
            'data' => $myLeaves
        ]);
    }

    public function mynews()
    {
        $myLeaves = Leave::where('user_id', auth()->user()->id)->get();
        return response()->json([
            'status' => true,
            'message' => 'Vos informations',
            'data' => $myLeaves
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
        Validator::make($request->all(), [
            'leave_type' =>['required'],
            'start_date' =>['required'],
            'end_date' =>['required'],
            'reason' =>['nullable'],
        ])->validate();

        $leave = Leave::create([
            'user_id' =>Auth::user()->id,
            'leave_type' =>$request->leave_type,
            'status' => 'en attente',
            'start_date' =>$request->start_date,
            'end_date' =>$request->end_date,
            'reason' =>$request->equipments,
        ]);

        return response()->json([
            'status' => true,
            'message' => "La demande de congés a bien été créee!",
            'product' => $leave
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
    public function update(Request $request, string $id)
    {
        Validator::make($request->all(), [
            'leave_type' =>['required'],
            'start_date' =>['required'],
            'end_date' =>['required'],
            'reason' =>['nullable'],
        ])->validate();

        $metting = Leave::findOrFail($id);
        $metting->update([
            'user_id' =>Auth::user()->id,
            'leave_type' =>$request->leave_type,
            'status' => $metting->status,
            'start_date' =>$request->start_date,
            'end_date' =>$request->end_date,
            'reason' =>$request->equipments,
        ]);

        return response()->json([
            'status' => true,
            'message' => "La demande de congés a bien été modifiée!",
            'product' => $metting
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $metting = Leave::findOrFail($id);
            $metting->delete();
            return response()->json([
                'status' => true,
                'message' => "La demande de congés a bien été supprimée!",   
            ]);
    }

    public function unauthorize(){
        return response()->json([
            'status' => true,
            'message' => "Vous n'avez pas les droits neccesaire pour cette action",
        ], 200);
    }
}
