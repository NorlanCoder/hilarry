<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [UserController::class, 'index'])->name('homefood');

Route::get('/favories', [UserController::class, 'listesFavories'])->name('favories')->middleware('auth');

Route::get('/addfavorie/{food}', [UserController::class, 'addfavorie'])->name('addfavorie')->middleware('auth');

Route::post('/trans', [UserController::class, 'transaction'])->name('trans')->middleware('auth');

Route::get('/cat/{categorie}', [UserController::class, 'categorie'])->name('cat');

Route::get('/history', [UserController::class, 'history'])->name('history')->middleware('auth');

Route::get('/livrer/{orderitem}', [UserController::class, 'livrer'])->name('livrer')->middleware('auth');

Route::get('/user', [UserController::class, 'compte'])->name('compte')->middleware('auth');

Route::put('/userupdate', [UserController::class, 'update'])->name('userupdate')->middleware('auth');

Route::get('/indexrecom/{name}', [UserController::class, 'indexrecom'])->name('indexrecom');

Route::get('/admincat/{categorie}', [AdminController::class, 'categorie'])->name('admincat');

Route::get('/blocklist/{bool}', [AdminController::class, 'userblock'])->name('blocklist')->middleware('auth');

Route::get('/livreur/{orderitem}', [AdminController::class, 'livrer'])->name('livreur')->middleware('auth');

Route::get('/order', [AdminController::class, 'history'])->name('order')->middleware('auth');

Route::get('/allow/{permissionid}/{usercible}', [AdminController::class, 'permission'])->name('allow')->middleware('auth');

Route::get('/allows', [AdminController::class, 'role'])->name('allows')->middleware('auth');

Route::get('/edit/{food}', [AdminController::class, 'edit'])->name('editfood')->middleware('auth');

Route::get('/create', [AdminController::class, 'create'])->name('createfood')->middleware('auth');

Route::post('/store', [AdminController::class, 'store'])->name('storefood')->middleware('auth');

Route::put('/update/{food}', [AdminController::class, 'update'])->name('updatefood')->middleware('auth');

Route::get('/admin', [AdminController::class, 'index'])->name('indexfood')->middleware('auth');

Route::get('/blockeduser/{user}', [AdminController::class, 'blockeduser'])->name('blockeduser')->middleware('auth');

Route::get('/foodblocked/{food}', [AdminController::class, 'blockedfood'])->name('blockedfood')->middleware('auth');

Route::get('/foodrecom/{food}', [AdminController::class, 'recommandedfood'])->name('recommandedfood')->middleware('auth');

Route::get('/adminuser', [AdminController::class, 'indexuser'])->name('indexuser')->middleware('auth');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::get('/cart/{food}', [CartController::class, 'addcart'])->name('cart.addcart');

Route::put('/cart/update', [CartController::class, 'updatecard'])->name('cart.updatecart');

Route::delete('/cart/delete', [CartController::class, 'removeItem'])->name('cart.remove');




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
