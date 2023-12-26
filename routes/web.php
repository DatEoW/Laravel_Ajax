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
    return view('index');
})->middleware(['auth']);
Route::resource('user', Usercontroller::class,);


Route::post('/update-user/{id}',[Usercontroller::class,'updateUser']);
Route::get('/search_user',[Usercontroller::class,'search_user'])->name('search_user');

Route::get('/list-user',[Usercontroller::class,'list_user'])->name('list-user');










Route::get('/login',[AuthController::class,'to_login'])->name('to_login');
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::delete('/logout',[AuthController::class,'logout'])->name('logout')->middleware('auth');







