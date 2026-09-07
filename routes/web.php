<?php

use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::controller(RecipeController::class)
    ->prefix('admin')
    ->group(function () {
        Route::controller(RecipeController::class)
            ->prefix('recipe')
            ->group(function () {
                Route::get('/add', 'index');
                Route::post('/create', 'create');
            });
    });

Route::controller(RecipeController::class)->group(function () {
    Route::get('/menu', 'menu');
});
