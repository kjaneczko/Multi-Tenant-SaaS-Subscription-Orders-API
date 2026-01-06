<?php

use App\Http\Controllers\AuditLog\ListAuditLogController;
use App\Http\Controllers\AuditLog\ShowAuditLogController;
//use Illuminate\Http\Request;
use App\Http\Controllers\Order\CreateOrderController;
use App\Http\Controllers\Order\ListOrderController;
use App\Http\Controllers\Order\ShowOrderController;
use App\Http\Controllers\OrderItem\CreateOrderItemController;
use App\Http\Controllers\OrderItem\ListOrderItemController;
use App\Http\Controllers\OrderItem\ShowOrderItemController;
use App\Http\Controllers\Payment\CreatePaymentController;
use App\Http\Controllers\Payment\ListPaymentController;
use App\Http\Controllers\Payment\ShowPaymentController;
use App\Http\Controllers\Subscription\CreateSubscriptionController;
use App\Http\Controllers\Subscription\ListSubscriptionController;
use App\Http\Controllers\Subscription\ShowSubscriptionController;
use App\Http\Controllers\Tenant\CreateTenantController;
use App\Http\Controllers\Tenant\ListTenantController;
use App\Http\Controllers\Tenant\ShowTenantController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Product\CreateProductController;
use App\Http\Controllers\Product\ListProductController;
use App\Http\Controllers\Product\ShowProductController;

use App\Http\Controllers\User\CreateUserController;
use App\Http\Controllers\User\ListUserController;
use App\Http\Controllers\User\ShowUserController;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::group(['prefix' => 'audit_logs'], function () {
    Route::get('/', ListAuditLogController::class);
    Route::get('/{id}', ShowAuditLogController::class);
});

Route::group(['prefix' => 'tenants'], function () {
    Route::get('/', ListTenantController::class);
    Route::get('/{id}', ShowTenantController::class);
    Route::post('/', CreateTenantController::class);
});

Route::group(['prefix' => 'products'], function () {
    Route::get('/', ListProductController::class);
    Route::get('/{id}', ShowProductController::class);
    Route::post('/', CreateProductController::class);
});

Route::group(['prefix' => 'users'], function () {
    Route::get('/', ListUserController::class);
    Route::get('/{id}', ShowUserController::class);
    Route::post('/', CreateUserController::class);
});

Route::prefix('payments')->group(function () {
    Route::get('/', ListPaymentController::class);
    Route::get('{id}', ShowPaymentController::class);
    Route::post('/', CreatePaymentController::class);
});

Route::prefix('orders')->group(function () {
    Route::get('/', ListOrderController::class);
    Route::get('{id}', ShowOrderController::class);
    Route::post('/', CreateOrderController::class);
});

Route::prefix('order-items')->group(function () {
    Route::get('/', ListOrderItemController::class);
    Route::get('{id}', ShowOrderItemController::class);
    Route::post('/', CreateOrderItemController::class);
});

Route::prefix('subscriptions')->group(function () {
    Route::get('/', ListSubscriptionController::class);
    Route::get('{id}', ShowSubscriptionController::class);
    Route::post('/', CreateSubscriptionController::class);
});
