<?php

use App\Http\Controllers\AuditLog\CreateAuditLogController;
use App\Http\Controllers\AuditLog\ListAuditLogController;
use App\Http\Controllers\AuditLog\ShowAuditLogController;
//use Illuminate\Http\Request;
use App\Http\Controllers\Tenant\CreateTenantController;
use App\Http\Controllers\Tenant\ListTenantController;
use App\Http\Controllers\Tenant\ShowTenantController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::group(['prefix' => 'audit_logs'], function () {
    Route::get('/', ListAuditLogController::class);
    Route::get('/{id}', ShowAuditLogController::class);
    Route::post('/', CreateAuditLogController::class);
});

Route::group(['prefix' => 'tenants'], function () {
    Route::get('/', ListTenantController::class);
    Route::get('/{id}', ShowTenantController::class);
    Route::post('/', CreateTenantController::class);
});
