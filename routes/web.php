<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->group(function () {
        Route::get('/logout', Logout::class)->name('logout');

        Route::controller(UserController::class)
            ->middleware('guest')
            ->group(function () {
                Route::post('/login', Login::class)->name('login');
                Route::get('/login', 'login');
                Route::post('/register', Register::class)->name('register');
                Route::get('/signup', 'signup');
            });
    });

Route::controller(RecipeController::class)
    ->prefix('recipe')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/create', 'create');

        Route::controller(RecipeController::class)
            ->prefix('{recipe}')
            ->group(function () {
                Route::get('/delete', 'delete');
            });
    });

Route::controller(RecipeController::class)
    ->group(function () {
        Route::get('/menu', 'menu')->name('menu');
        Route::get('/', 'welcome')->name('welcome');
    });

Route::controller(ReservationController::class)
    ->prefix('reservation')
    ->group(function () {
        Route::get('/', 'view');
        Route::post('/', 'view');
        Route::get('/create', 'index');
        Route::post('/create', 'create');

        Route::controller(ReservationController::class)
            ->prefix('{reservation}')
            ->group(function () {
                Route::get('/delete', 'delete');
            });
    });
