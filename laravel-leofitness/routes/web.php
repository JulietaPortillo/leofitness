<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MembersController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AclController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\ServicesController;
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

//User Module with roles & permissions
//User
Route::group(['prefix' => 'user', 'middleware' => ['permission:Administrador', 'auth']], function () {
    Route::get('/', [AclController::class, 'userIndex']);
    Route::get('create', [AclController::class, 'createUser']);
    Route::post('/', [AclController::class, 'storeUser']);
    Route::get('{id}/edit', [AclController::class, 'editUser'])->name('user.edit');
    Route::post('{id}/update', [AclController::class, 'updateUser']);
    Route::post('{id}/delete', [AclController::class, 'deleteUser']);
});

//Roles
Route::group(['prefix' => 'user/role', 'middleware' => ['permission:Administrador', 'auth']], function () {
    Route::get('/', [AclController::class, 'roleIndex']);
    Route::get('create', [AclController::class, 'createRole'])->name('role.create');
    Route::post('/', [AclController::class, 'storeRole']);
    Route::get('{id}/edit', [AclController::class, 'editRole'])->name('role.edit');
    Route::post('{id}/update', [AclController::class, 'updateRole'])->name('role.update');
    Route::post('{id}/delete', [AclController::class, 'deleteRole'])->name('role.delete');
});

//Permissions
Route::group(['prefix' => 'user/permission', 'middleware' => ['permission:Administrador', 'auth']], function () {
    Route::get('/', [AclController::class, 'permissionIndex'])->name('permission.index');
    Route::get('create', [AclController::class, 'createPermission'])->name('permission.create');
    Route::post('/', [AclController::class, 'storePermission']);
    Route::get('{id}/edit', [AclController::class, 'editPermission'])->name('permission.edit');
    Route::post('{id}/update', [AclController::class, 'updatePermission'])->name('permission.update');
    Route::post('{id}/delete', [AclController::class, 'deletePermission'])->name('permission.delete');
});

//settings
Route::middleware(['permission:manage-gymie|manage-settings', 'auth'])->prefix('settings')->group(function () {
    Route::get('/', [SettingsController::class, 'show'])->name('settings.show');
    Route::get('edit', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::post('save', [SettingsController::class, 'save'])->name('settings.save');
});


// plans
Route::middleware(['auth'])->prefix('plans')->group(function () {
    Route::middleware(['permission:manage-gymie|manage-plans|view-plan'])->group(function () {
        Route::get('/', [PlansController::class, 'index'])->name('plans.index');
        Route::get('all', [PlansController::class, 'index'])->name('plans.all');
        Route::get('show', [PlansController::class, 'show'])->name('plans.show');
    });

    Route::middleware(['permission:manage-gymie|manage-plans|add-plan'])->group(function () {
        Route::get('create', [PlansController::class, 'create'])->name('plans.create');
        Route::post('/', [PlansController::class, 'store']);
    });

    Route::middleware(['permission:manage-gymie|manage-plans|edit-plan'])->group(function () {
        Route::get('{id}/edit', [PlansController::class, 'edit'])->name('plans.edit');
        Route::post('{id}/update', [PlansController::class, 'update']);
    });

    Route::middleware(['permission:manage-gymie|manage-plans|delete-plan'])->group(function () {
        Route::post('{id}/archive', [PlansController::class, 'archive']);
    });

    Route::middleware(['permission:manage-gymie|manage-services|view-service'])->group(function () {
        Route::get('/services', [ServicesController::class, 'index'])->name('services.index');
        Route::get('services/all', [ServicesController::class, 'index'])->name('services.all');
    });

    Route::middleware(['permission:manage-gymie|manage-services|add-service'])->group(function () {
        Route::get('services/create', [ServicesController::class, 'create'])->name('services.create');
        Route::post('/services', [ServicesController::class, 'store']);
    });

    Route::middleware(['permission:manage-gymie|manage-services|edit-service'])->group(function () {
        Route::get('services/{id}/edit', [ServicesController::class, 'edit'])->name('services.edit');
        Route::post('services/{id}/update', [ServicesController::class, 'update'])->name('services.update');
    });

    Route::middleware(['permission:manage-gymie|manage-services|delete-service'])->group(function () {
        Route::post('services/{id}/delete', [ServicesController::class, 'delete']);
    });
});


