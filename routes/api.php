<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\{ProductController, ImageController};
use App\Http\Controllers\{CategoryController, PermissionController, RoleController, UserController};
use App\Http\Controllers\Auth\{LoginController, RegisterController, MeController, LogoutController, VerifyEmailController, ForgotPasswordController, ResetPasswordController};

Route::post('login', LoginController::class)->name('auth.login');
Route::post('register', RegisterController::class)->name('auth.register');
Route::post('verify-email', VerifyEmailController::class)->name('check.email');
Route::post('forgot-password', ForgotPasswordController::class);
Route::post('reset-password', ResetPasswordController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('me', MeController::class);
    Route::post('logout', LogoutController::class);

    Route::apiResource('users', UserController::class);
    Route::post('user/{user}/set-role', [UserController::class, 'setRole']);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('product/images', ImageController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('permissions', PermissionController::class);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
