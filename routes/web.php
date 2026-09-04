<?php

use App\Http\RecipeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller(RecipeController::class)
    ->prefix('recipe')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/create', 'create');
    });
