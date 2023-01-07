<?php

use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\PermissionController;
use App\Http\Controllers\api\v1\RoleController;
use App\Http\Controllers\api\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 9|mCI7SI1jT0shdkjGcuXGU0yNBU6oejXMPTnPSFSd
Route::group(['prefix' => 'v1', 'as' => 'v1.'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('users/permission', [UserController::class, 'userpermissionstore']);
        Route::resource('users', UserController::class);
        Route::post('roles/permission', [RoleController::class, 'rolespermissionstore']);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
    });
});
