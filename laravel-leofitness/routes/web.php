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
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\InvoicesController;
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
    Route::get('{id}/transfer', ['middleware' => ['permission:manage-gymie|manage-enquiries|transfer-enquiry'], 'uses' => 'MembersController@transfer']);
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

Route::middleware(['auth'])->group(function () {
    Route::middleware(['permission:manage-gymie|manage-subscriptions|view-subscription'])->group(function () {
        Route::get('/subscriptions', [SubscriptionsController::class, 'index'])->name('subscriptions.index');
        Route::get('subscriptions/all', [SubscriptionsController::class, 'index'])->name('subscriptions.all');
        Route::get('subscriptions/expiring', [SubscriptionsController::class, 'expiring'])->name('subscriptions.expiring');
        Route::get('subscriptions/expired', [SubscriptionsController::class, 'expired'])->name('subscriptions.expired');
        Route::get('subscriptions/{id}/show', [SubscriptionsController::class, 'show'])->name('subscriptions.show');
    });

    Route::middleware(['permission:manage-gymie|manage-subscriptions|add-subscription'])->group(function () {
        Route::get('subscriptions/create', [SubscriptionsController::class, 'create'])->name('subscriptions.create');
        Route::post('/subscriptions', [SubscriptionsController::class, 'store']);
    });

    Route::middleware(['permission:manage-gymie|manage-subscriptions|edit-subscription'])->group(function () {
        Route::get('subscriptions/{id}/edit', [SubscriptionsController::class, 'edit'])->name('subscriptions.edit');
        Route::post('subscriptions/{id}/update', [SubscriptionsController::class, 'update'])->name('subscriptions.update');
        Route::get('subscriptions/{id}/change', [SubscriptionsController::class, 'change'])->name('subscriptions.change');
        Route::post('subscriptions/{id}/modify', [SubscriptionsController::class, 'modify'])->name('subscriptions.modify');
        Route::get('subscriptions/{id}/renew', [SubscriptionsController::class, 'renew'])->name('subscriptions.renew');
    });

    Route::middleware(['permission:manage-gymie|manage-subscriptions|cancel-subscription'])->group(function () {
        Route::post('subscriptions/{id}/cancelSubscription', [SubscriptionsController::class, 'cancelSubscription'])->name('subscriptions.cancelSubscription');
    });

    Route::middleware(['permission:manage-gymie|manage-subscriptions|delete-subscription'])->group(function () {
        Route::post('subscriptions/{id}/delete', [SubscriptionsController::class, 'delete'])->name('subscriptions.delete');
    });
});

//invoices
Route::middleware(['auth'])->group(function () {
    Route::middleware(['permission:manage-gymie|manage-invoices|view-invoice'])->group(function () {
        Route::get('/invoices', [InvoicesController::class, 'index'])->name('invoices.index');
        Route::get('invoices/all', [InvoicesController::class, 'index'])->name('invoices.all');
        Route::get('invoices/paid', [InvoicesController::class, 'paid'])->name('invoices.paid');
        Route::get('invoices/unpaid', [InvoicesController::class, 'unpaid'])->name('invoices.unpaid');
        Route::get('invoices/partial', [InvoicesController::class, 'partial'])->name('invoices.partial');
        Route::get('invoices/overpaid', [InvoicesController::class, 'overpaid'])->name('invoices.overpaid');
        Route::get('invoices/{id}/show', [InvoicesController::class, 'show'])->name('invoices.show');
    });

    Route::middleware(['permission:manage-gymie|manage-invoices|add-payment'])->group(function () {
        Route::get('invoices/{id}/payment', [InvoicesController::class, 'createPayment'])->name('invoices.createPayment');
    });

    Route::middleware(['permission:manage-gymie|manage-invoices|delete-invoice'])->group(function () {
        Route::post('invoices/{id}/delete', [InvoicesController::class, 'delete'])->name('invoices.delete');
    });

    Route::middleware(['permission:manage-gymie|manage-invoices|add-discount'])->group(function () {
        Route::get('invoices/{id}/discount', [InvoicesController::class, 'discount'])->name('invoices.discount');
        Route::post('invoices/{id}/applyDiscount', [InvoicesController::class, 'applyDiscount'])->name('invoices.applyDiscount');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::middleware(['permission:manage-gymie|manage-payments|view-payment'])->group(function () {
        Route::get('/payments', [PaymentsController::class, 'index'])->name('payments.index');
        Route::get('payments/all', [PaymentsController::class, 'index'])->name('payments.all');
        Route::get('payments/show', [PaymentsController::class, 'show'])->name('payments.show');
    });

    Route::middleware(['permission:manage-gymie|manage-payments|add-payment'])->group(function () {
        Route::get('payments/create', [PaymentsController::class, 'create'])->name('payments.create');
        Route::post('/payments', [PaymentsController::class, 'store']);
    });

    Route::middleware(['permission:manage-gymie|manage-payments|edit-payment'])->group(function () {
        Route::get('payments/{id}/edit', [PaymentsController::class, 'edit'])->name('payments.edit');
        Route::get('payments/{id}/clearCheque', [PaymentsController::class, 'clearCheque'])->name('payments.clearCheque');
        Route::get('payments/{id}/depositCheque', [PaymentsController::class, 'depositCheque'])->name('payments.depositCheque');
        Route::get('payments/{id}/chequeBounce', [PaymentsController::class, 'chequeBounce'])->name('payments.chequeBounce');
        Route::get('payments/{id}/chequeReissue', [PaymentsController::class, 'chequeReissue'])->name('payments.chequeReissue');
        Route::post('payments/{id}/update', [PaymentsController::class, 'update'])->name('payments.update');
    });

    Route::middleware(['permission:manage-gymie|manage-payments|delete-payment'])->group(function () {
        Route::post('payments/{id}/delete', [PaymentsController::class, 'delete'])->name('payments.delete');
    });
});

