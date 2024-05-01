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

    Route::get("/indexusers", [AdminController::class, "indexusers"]);
    Route::get("/indexdepartments", [AdminController::class, "indexdepartments"]);
    Route::get("/indexleaves", [AdminController::class, "indexleaves"]);
    Route::get("/indexsalaries/{id}", [AdminController::class, "indexsalaries"]);
    Route::get("/indexhistories/{id}", [AdminController::class, "indexhistories"]);
    Route::post("/department/create", [AdminController::class, "storedepartment"]);
    Route::post("/salary/create/{id}", [AdminController::class, "storesalary"]);
    Route::post("/history/create/{id}", [AdminController::class, "storehistory"]);
    Route::put("/department/update/{id}", [AdminController::class, "updatedepartment"]);
    Route::put("/salary/update/{id}", [AdminController::class, "updatesalary"]);
    Route::put("/history/update/{id}", [AdminController::class, "updatehistory"]);
    Route::put("/responseleave/{id}", [AdminController::class, "responseleave"]);
    Route::get("/search", [AdminController::class, "searchEmployees"]);
    
    Route::post("/histories", [UserController::class, "indexhistories"]);
    Route::post("/salaries", [UserController::class, "indexsalaries"]);
    Route::get("/leaves", [UserController::class, "index"]);
    Route::get("/mynews", [UserController::class, "mynews"]);
    Route::post("/leave/create", [UserController::class, "store"]);
    Route::put("/leave/update/{id}", [UserController::class, "update"]);
    Route::delete("/leave/destroy/{id}", [UserController::class, "destroy"]);
    Route::get("/unauthorize}", [UserController::class, "unauthorize"])->name('unauthorize');