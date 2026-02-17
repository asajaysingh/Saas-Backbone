<?php 
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\OrganizationController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\RoleController;


Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/organizations', [OrganizationController::class, 'store']);
        Route::get('/organizations', [OrganizationController::class, 'index']);
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('organizations/{organizationId}/roles', [RoleController::class, 'index']);
        Route::post('organizations/{organizationId}/roles', [RoleController::class, 'store']);
        Route::put('roles/{id}', [RoleController::class, 'update']); 
        Route::delete('roles/{id}', [RoleController::class, 'destroy']); 
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/users', [UserController::class, 'store'])
        ->middleware('permission:create_user');
    Route::get('/users', [UserController::class, 'index'])
        ->middleware('permission:view_users');
    });
});