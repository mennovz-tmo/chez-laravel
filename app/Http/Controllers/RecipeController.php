<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    public function index()
    {
        return view('admin.recipe.index');
    }

    public function create(Request $request)
    {
        $validator = $request->validate([
            'name' => ['bail', 'required', 'min:3', 'max:255'],
            'description_short' => ['required', 'min:16', 'max:1023'],
            'allergens' => ['required', 'string', 'min:3'],
            'price' => ['required', 'decimal:2', 'min:0.01'],
            // 'picture' => ['required', '', 'min:3']
            // ^^^ My brain I thought it was already a string ready for saving here. :) LOL.
            'picture' => ['required', 'image'],
        ]);

        $picture_loc = '';
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

        return redirect('/admin/recipe/add');
    }

    public function delete() {}

    public function menu()
    {
        $recipes = Recipe::get();

        return view('menu.index', ['recipes' => $recipes]);
    }

    public function welcome()
    {
        return view('welcome');
    }
}
