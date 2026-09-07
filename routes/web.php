<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->group(function () {
        Route::prefix('auth')
            ->group(function () {
                Route::post('/login', Login::class)->name('login');
                Route::post('/register', Register::class)->name('register');
                Route::get('/logout', Logout::class)->name('logout');

                Route::controller(UserController::class)
                    ->middleware('guest')
                    ->group(function () {
                        Route::get('/login', 'login');
                        Route::get('/signup', 'signup');
                    });
            });

        Route::controller(RecipeController::class)
            ->prefix('recipe')
            ->middleware('auth')
            ->group(function () {
                Route::get('/add', 'index');
                Route::post('/create', 'create');
            });
    });

Route::controller(RecipeController::class)
    ->group(function () {
        Route::get('/menu', 'menu')->name('menu');
        Route::get('/', 'welcome')->name('welcome');
    });
