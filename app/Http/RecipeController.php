<?php

namespace App\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{
    public function index() {
        $recipes = Recipe::get();

        return view('recipes.index', ['recipes' => $recipes]);
    }

    public function create(Request $request) {
        
    }
}
