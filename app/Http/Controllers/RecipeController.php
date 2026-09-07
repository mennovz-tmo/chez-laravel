<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::get();

        return view('recipes.index', ['recipes' => $recipes]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $picture_loc = "";
            if ($request->file('picture')->isValid()) {
                // dd(hash_algos());
                $hash = hash('sha3-224', $request->file('picture')->path());  // Get a unique filename
                // $hash = $request->file('picture')->hashName();
                $name = $request->file('picture')->getClientOriginalName();  // Get the original filename
                $name = str_replace(' ', '_', $name);  // Remove spaces for compatability
                // $extension = $request->file('picture')->extension();
                $request->file('picture')->storeAs('./uploads/', "{$hash}-{$name}", 'public');
                $picture_loc = "/storage/uploads/{$hash}-{$name}";
            }
            Recipe::fillAndInsert([
                'name' => $request->input('name'),
                'description_short' => $request->input('description_short'),
                'allergens' => $request->input('allergens'),
                'price' => $request->input('price'),
                'picture' => $picture_loc,
            ]);
        }
    }
}
