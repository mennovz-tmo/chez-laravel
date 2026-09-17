<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\OpeningDatetimeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AccountRegistrationState;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->group(function () {
        Route::get('/logout', Logout::class)->name('logout');

        Route::controller(UserController::class)
            ->middleware('guest')
            ->group(function () {
                Route::post('/login', Login::class)->name('login.submit');
                Route::get('/login', 'login')->name('login');
                Route::post('/register', Register::class)->name('register.submit')->middleware(AccountRegistrationState::class);
                Route::get('/signup', 'signup')->name('register')->middleware(AccountRegistrationState::class);
            });
    });

Route::middleware('auth')
    ->prefix('email')
    ->controller(EmailVerificationController::class)
    ->group(function () {
        Route::get('/verify', 'notice')->name('verification.notice');
        Route::get('/verify/{id}/{hash}', 'verify')->name('verification.verify')->middleware('signed');
        Route::post('/resend', 'resend')->name('verification.send')->middleware('throttle:6,1');
    });

Route::controller(RecipeController::class)
    ->prefix('recipe')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/', 'index')->name('recipe.create');
        Route::post('/create', 'create')->name('recipe.store');

        Route::controller(RecipeController::class)
            ->prefix('{recipe}')
            ->missing(fn () => ErrorController::handleError(route('menu'), ['Het id dat is opgevraagd bestaat niet.']))
            ->group(function () {
                Route::get('/delete', 'delete')->name('recipe.delete');
                Route::match(['get', 'post'], '/edit', 'edit')->name('recipe.edit');
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
        Route::match(['get', 'post'], '/', 'view')->name('reservation.view');
        Route::get('/create', 'index')->name('reservation.create');
        Route::post('/create', 'create')->name('reservation.store');

        Route::controller(ReservationController::class)
            ->prefix('{reservation}')
            ->missing(fn () => ErrorController::handleError(route('reservation.view'), ['De reservering die is opgevraagd bestaat niet']))
            ->group(function () {
                Route::get('/delete', 'delete')->name('reservation.delete.request');
                Route::get('/delete/{delete_token}', 'delete')->name('reservation.delete.confirm');
                Route::match(['get', 'post'], '/edit', 'edit')->name('reservation.edit');
                Route::get('/show', 'show')->name('reservation.show');
            });
    });

Route::controller(OpeningDatetimeController::class)
    ->prefix('opening-datetime')
    ->group(function () {
        Route::get('/', 'index')->name('opening-datetime.view');
        Route::post('/create', 'create')->name('opening-datetime.create')->middleware(['auth', 'verified']);

        Route::controller(OpeningDatetimeController::class)
            ->middleware(['auth', 'verified'])
            ->prefix('{openingDatetime}')
            ->missing(fn () => ErrorController::handleError(route('opening-datetime.view'), ['De openingstijd die is opgevraagd bestaat niet']))
            ->group(function () {
                Route::get('/delete', 'delete')->name('opening-datetime.delete');
                Route::match(['get', 'post'], '/edit', 'edit')->name('opening-datetime.edit');
            });
    });
