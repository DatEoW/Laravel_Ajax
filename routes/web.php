<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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
    return view('product_pm');
})->middleware(['auth']);
Route::resource('user', UserController::class)->middleware(['auth','role']);

Route::post('/changeUser',[UserController::class,'changeUser'])->name('changeUser')->middleware(['auth','role']);

Route::resource('product', ProductController::class)->middleware(['auth']);

















Route::get('/login',[AuthController::class,'to_login'])->name('to_login');
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::delete('/logout',[AuthController::class,'logout'])->name('logout')->middleware('auth');







