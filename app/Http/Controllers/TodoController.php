<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Todo::all();
            return response()->json([
                'status' => true,
                'message' => 'Voici toutes vos tâches',
                'products' => $products
            ]);
        } catch (AuthenticationException $exception) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
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
        $validator = Validator::make($request->all(), [
            'title' =>['required'],
            'description' =>['required', 'min:8'],
        ]);

        if($validator->fails()){
            return response($validator->errors(),400);
        }

        $todo = Todo::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Votre nouvelle tâche a bien été ajoutée!",
            'product' => $todo
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
            'title' =>['required'],
            'description' =>['required', 'min:8'],
        ])->validate();

        $todo = Todo::findOrFail($id);
        $todo->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Cette tâche a bien été modifiée!",
            'product' => $todo
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        return response()->json([
            'status' => true,
            'message' => "Cette tâche a bien été supprimée!",   
        ]);
    }
}
