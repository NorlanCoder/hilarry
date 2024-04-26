<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function() {
    $data = [
        'message' => "Welcome to our API"
    ];
    return response()->json($data, 200);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/users', [AuthController::class, 'index']);
Route::get('/unauthorize', [AuthController::class, 'unauthorize'])->name('unauthorize');


Route::middleware('auth:sanctum')->group(function() {
    Route::get("/todos", [TodoController::class, "index"]);
    Route::post("/todos/create", [TodoController::class, "store"]);
    Route::put("/todos/update/{id}", [TodoController::class, "update"]);
    Route::delete("/todos/delete/{id}", [TodoController::class, "destroy"]);
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum' ,'ability:' . 'issue-access-token') -> group (function () { 
    Route :: get ( '/auth/refresh-token' , [AuthController::class, 'refreshToken' ]); 
});
