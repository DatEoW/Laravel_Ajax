<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserController1;

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

Route::get('', function () {
    return view('user_um');
})->middleware(['auth']);
Route::resource('user', UserController::class,);


Route::post('/update-user/{id}',[UserController::class,'updateUser']);
Route::get('/search_user',[UserController::class,'search_user'])->name('search_user');

Route::get('/list-user',[UserController::class,'list_user'])->name('list-user');

Route::post('/deleteUser',[UserController::class,'deleteUser'])->name('deleteUser');










Route::get('/login',[AuthController::class,'to_login'])->name('to_login');
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::delete('/logout',[AuthController::class,'logout'])->name('logout')->middleware('auth');







