<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group( function() {
    Route::controller(AuthController::class)->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::get('/me', 'me');

            Route::post('/logout', 'logout');
        });

        Route::middleware('api')->group(function () {
            Route::post('/login', 'login');
            Route::post('/refresh', 'refreshToken');
        });
    });
});

Route::prefix('users')->group( function() {
    Route::controller(UserController::class)->group( function() {
        Route::middleware('auth:api')->group(function () {
            Route::get('/', 'getUsers');
            Route::get('/{id}', 'getUserById');
            Route::get('/logged-user', 'getLoggedUser');

            Route::post('/', 'create');

            Route::put('/{id}', 'update');

            Route::patch('/{id}/enable', 'enable');
            Route::patch('/{id}/disable', 'disable');

            Route::delete('/{id}/delete', 'delete');
        });

        Route::middleware('api')->group(function () {
            Route::post('/forgot-password', 'forgotPassword');
            Route::post('/reset-password', 'resetPassword');
            Route::post('/external', 'createExternal');
            Route::put('/external/{id}', 'updateExternal');
            Route::get('/external/{id}', 'getUserByIdExternal');
        });
    });
});

Route::prefix('establishments')->group( function() {
    Route::controller(EstablishmentController::class)->group( function() {
        Route::middleware('auth:api')->group(function () {
            Route::post('/', 'create');

            Route::put('/{id}', 'update');

            Route::delete('/{id}', 'delete');

            Route::get('/', 'getEstablishments');
            Route::get('/{id}', 'getEstablishmentById');
        });
    });
});
