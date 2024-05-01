<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\EmploymentHistory;
use App\Models\Leave;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

   /* public function __construct()
    {
        $this->middleware('checkUserStatus');
    }*/


    /**
     * Display a listing of the resource.
     */
    public function indexusers()
    {
        $users = User::all();
        return response()->json([
            'status' => true,
            'message' => 'Voici la liste de tous vos employés',
            'data' => $users
        ]);
    }

    public function indexdepartments()
    {
        $departments = Department::all();
        return response()->json([
            'status' => true,
            'message' => 'Voici la listes de tous les departements du service',
            'data' => $departments
        ]);
    }

    public function indexleaves()
    {
        $leaves = Leave::all();
        return response()->json([
            'status' => true,
            'message' => 'Voici la listes de tous vos employés',
            'data' => $leaves
        ]);
    }

    public function indexsalaries(string $id)
    {
        $salarie = Salary::where('user_id',$id)->get();
        return response()->json([
            'status' => true,
            'message' => 'Voici la listes de tous vos employés',
            'data' => $salarie
        ]);
    }

    public function indexhistories(string $id)
    {
        $histories = EmploymentHistory::where('user_id',$id)->get();
        return response()->json([
            'status' => true,
            'message' => 'Voici la listes de tous vos employés',
            'data' => $histories
        ]);
    }

    public function responseleave(string $id,Request $request)
    {
        $leave = Leave::find($id);
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
    public function storedepartment(Request $request)
    {
        Validator::make($request->all(), [
            'manager_id' =>['required'],
            'name' =>['required'],
        ]);

        $department = Department::create([
            'manager_id' =>$request->manager_id,
            'name' =>$request->name,
        
        ]);

        return response()->json([
            'status' => true,
            'message' => "Un nouveau departement a bien été créee!",
            'data' => $department
        ], 200);
    }

    public function storesalary(string $id, Request $request)
    {
        Validator::make($request->all(), [
            'amount' =>['required', 'integer'],
            'type' =>['required'],
            'interval' =>['required'],
            'date_pay' =>['required'],
        ]);

        $department = Salary::create([
            'amount' =>$request->amount,
            'type' =>$request->type,
            'interval' =>$request->interval,
            'date_pay' =>$request->date_pay,
            'user_id' =>$id,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Une nouvelle paie de salaire a bien été créee!",
            'data' => $department
        ], 200);
    }

    public function storehistory(string $id, Request $request)
    {
        Validator::make($request->all(), [
            'job' =>['required'],
            'start_date' =>['required'],
            'end_date' =>['required'],
            'affect_reason' =>['required'],
        ]);

        $department = EmploymentHistory::create([
            'job' =>$request->job,
            'start_date' =>$request->start_date,
            'end_date' =>$request->end_date,
            'affect_reason' =>$request->affect_reason,
            'user_id' =>$id,
            'department_id' => User::find($id)->department_id,
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
    public function updatedepartment(Request $request, string $id)
    {
        Validator::make($request->all(), [
            'manager_id' =>['required'],
            'name' =>['required'],
        ]);

        $department = Department::find($id);
        $department = $department->update([
            'manager_id' =>$request->manager_id,
            'name' =>$request->name,
        
        ]);

        return response()->json([
            'status' => true,
            'message' => "Ce departement a bien été mise à jour!",
            'data' => $department
        ], 200);
    }

    public function updatesalary(Request $request, string $id)
    {
        Validator::make($request->all(), [
            'amount' =>['required', 'integer'],
            'type' =>['required'],
            'interval' =>['required'],
            'date_pay' =>['required'],
        ]);

        $salary = Salary::find($id);
        $department = $salary->update([
            'amount' =>$request->amount,
            'type' =>$request->type,
            'interval' =>$request->interval,
            'date_pay' =>$request->date_pay,
            'user_id' =>$id,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Une nouvelle paie de salaire a bien été mise à jour!",
            'data' => $department
        ], 200);
    }

    public function updatehistory(Request $request, string $id)
    {
        Validator::make($request->all(), [
            'job' =>['required'],
            'start_date' =>['required'],
            'end_date' =>['required'],
            'affect_reason' =>['required'],
        ]);

        $history = EmploymentHistory::find($id);
        $department = $history->update([
            'job' =>$request->job,
            'start_date' =>$request->start_date,
            'end_date' =>$request->end_date,
            'affect_reason' =>$request->affect_reason,
            'user_id' =>$id,
            'department_id' => User::find($id)->department_id,
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

    public function searchEmployees(Request $request)
{
    $name = $request->name;
    $number = $request->number;
    $job = $request->job;

    $query = User::query();

    if (!is_null($name)) {
        $query->where('name', 'like', '%' . $name . '%');
    }

    if (!is_null($number)) {
        $query->where('id', $number);
    }

    if (!is_null($job)) {
        $query->where('job', 'like', '%' . $job . '%');
    }

    $results = $query->get();

    return response()->json([
        'status' => true,
        'message' => "",
        'data' => $results
    ], 200);
}
}
