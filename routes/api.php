<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/unauthorize', [AuthController::class, 'unauthorize'])->name('unauthorize');
Route::post('/research/{id_meeting}', [AuthController::class, 'research']);
Route::get("/meets", [AdminController::class, "index"]);


Route::middleware('auth:sanctum')->group(function() {
    Route::get('/users', [AuthController::class, 'index']);
    Route::get("/meetings", [AdminController::class, "indexmeet"]);
    Route::get('/blockuser/{id}', [AdminController::class, 'blockeduser']);
    Route::post("/meet/create", [AdminController::class, "store"]);
    Route::put("/meet/update/{id}", [AdminController::class, "update"]);
    Route::delete("/meet/destroy/{id}", [AdminController::class, "destroy"]);
    Route::delete("/meet/delete/{id}", [AdminController::class, "delete"]);
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/mymeeting', [UserController::class, 'myMetting']);
    Route::post('/domeet/{id_meeting}', [UserController::class, 'domeeting']);
    Route::delete('/cancemmeet/{id_meeting}', [UserController::class, 'cancelmeeting']);
});

Route::middleware('auth:sanctum' ,'ability:' . 'issue-access-token') -> group (function () { 
    Route :: get ( '/auth/refresh-token' , [AuthController::class, 'refreshToken' ]); 
});

