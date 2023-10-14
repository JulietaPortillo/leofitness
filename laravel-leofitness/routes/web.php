<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MembersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\Authenticate;

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
/*
Route::get('/', function () {
    return view('app');
});
*/


Route::get('/user', [UserController::class, 'show']);

//Unauthenticated routes
Route::name('login')->get('login', [AuthController::class, 'getLogin']);
Route::name('members.active')->get('/members/active', [MembersController::class, 'active']);

//Auth routes
Route::group(['prefix' => 'auth'], function () {
    Route::get('login', [AuthController::class, 'getLogin']);
    Route::post('login', [AuthController::class, 'postLogin']);
    Route::get('logout', [AuthController::class, 'getLogout']);
});

//dashboard
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    //Route::post('/dashboard/smsRequest', [DashboardController::class, 'smsRequest']);
});

//MembersController
Route::group(['prefix' => 'members', 'middleware' => ['auth']], function () {
    Route::get('/', [MembersController::class, 'index']);
    Route::get('all', [MembersController::class, 'index']);
    Route::get('active', [MembersController::class, 'active'])->name('members.active');
    Route::get('inactive', [MembersController::class, 'inactive']);
    Route::get('create', [MembersController::class, 'create']);
    Route::post('/', [MembersController::class, 'store']);
    Route::get('{id}/show', [MembersController::class, 'show']);
    Route::get('{id}/edit',  [MembersController::class, 'edit']);
    Route::post('{id}/update', [MembersController::class, 'update']);
    Route::post('{id}/archive', [MembersController::class, 'archive']);
    //Route::get('{id}/transfer', ['middleware' => ['permission:manage-gymie|manage-enquiries|transfer-enquiry'], 'uses' => 'MembersController@transfer']);
});
