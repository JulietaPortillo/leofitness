<?php

use App\Http\Middleware\Authenticate;
use App\Http\Controllers\DashboardController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->group(function () {
    Route::post('/token', [Authenticate::class, 'authenticate']);
});

Route::prefix('api')->middleware('jwt.auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('members', [MembersController::class, 'index']);
    //Route::get('subscriptions', [SubscriptionsController::class, 'index']);
    //Route::get('payments', [PaymentsController::class, 'index']);
    //Route::get('invoices', [InvoicesController::class, 'index']);
    //Route::get('invoices/paid', [InvoicesController::class, 'paid']);
    //Route::get('invoices/unpaid', [InvoicesController::class, 'unpaid']);
    //Route::get('invoices/partial', [InvoicesController::class, 'partial']);
    //Route::get('invoices/overpaid', [InvoicesController::class, 'overpaid']);
    //Route::get('enquiries', [EnquiriesController::class, 'index']);
    //Route::get('settings', [SettingsController::class, 'index']);
    //Route::get('plans', [PlansController::class, 'index']);
    //Route::get('expenseCategories', [ExpenseCategoriesController::class, 'index']);
    //Route::get('expenses', [ExpensesController::class, 'index']);
    //Route::get('subscriptions/expiring', [SubscriptionsController::class, 'expiring']);
    //Route::get('subscriptions/expired', [SubscriptionsController::class, 'expired']);
    Route::get('members/{id}', [MembersController::class, 'show']);
    //Route::get('subscriptions/{id}', [SubscriptionsController::class, 'show']);
    //Route::get('payments/{id}', [PaymentsController::class, 'show']);
    //Route::get('invoices/{id}', [InvoicesController::class, 'show']);
    //Route::get('enquiries/{id}', [EnquiriesController::class, 'show']);
    //Route::get('plans/{id}', [PlansController::class, 'show']);
    //Route::get('expenseCategories/{id}', [ExpenseCategoriesController::class, 'show']);
    //Route::get('expenses/{id}', [ExpensesController::class, 'show']);
});
