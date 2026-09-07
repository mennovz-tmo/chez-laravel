<?php

use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::controller(RecipeController::class)
    ->prefix('recipe')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/create', 'create');
    });

    