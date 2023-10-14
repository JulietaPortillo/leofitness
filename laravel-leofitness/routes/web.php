<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;

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

Route::get('/', function () {
    return view('app');
});

Route::get('/user', [UserController::class, 'show']);

//Auth routes
Route::group(['prefix' => 'auth'], function () {
    Route::get('login', [AuthController::class, 'getLogin']);
    Route::post('login', [AuthController::class, 'postLogin']);
    Route::get('logout', [AuthController::class, 'getLogout']);
});
