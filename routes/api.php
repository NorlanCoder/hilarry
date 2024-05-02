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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

//Route::get("/unauthorize", [UserController::class, "unauthorize"]);

Route::controller(UserController::class)->group(function () {
    Route::get('searchVol', 'searchVol');
    Route::get('searchHebergement', 'searchHebergement');
    Route::get('searchActivity', 'searchActivity');
    Route::post('reserverVol/{id}', 'reserverVol');
    Route::post('reserverHebergement/{id}', 'reserverHebergement');
    Route::post('reserverActivity/{id}', 'reserverActivity');
    Route::get('myActivities', 'myActivities');
    Route::get('myHebergement', 'myHebergement');
    Route::get('myVol', 'myVol');
    Route::put('updateProfil', 'updateProfil');
    Route::get('indexVols', 'indexVols');
    Route::get('indexactivities', 'indexactivities');
    Route::get('indexhebergements', 'indexhebergements');
    Route::get('unauthorize', 'unauthorize')->name('unauthorize');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('indexusers', 'indexusers');
    Route::get('allVols', 'allVols');
    Route::get('allhebergement', 'allhebergement');
    Route::get('allactivities', 'allactivities');
    Route::put('responsevol/{id}', 'responsevol');
    Route::put('responsehebergement/{id}', 'responsehebergement');
    Route::put('responseactivity/{id}', 'responseactivity');
    Route::post('storevol', 'storevol');
    Route::post('storehebergement', 'storehebergement');
    Route::post('storeactivity', 'storeactivity');
    Route::put('updatevol/{id}', 'updatevol');
    Route::put('updatehebergement/{id}', 'updatehebergement');
    Route::put('updateactivity/{id}', 'updateactivity');
});
