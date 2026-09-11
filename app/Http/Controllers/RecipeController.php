<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    public function index()
    {
        return view('recipe.index');
    }

    public function edit(Request $request, int $id)
    {
        if ($request->isMethod('GET')) {
            return view('recipe.edit')->with('current_data', (array) DB::select('select * from recipes where id = ?;', [$id])[0]);
        }

        $request->validate([
            'name' => ['bail', 'required', 'string', 'min:1', 'max:255'],
            'description_short' => ['required', 'min:1', 'max:1024'],
            'allergens' => ['required', 'string', 'min:1'],
            'price' => ['required', 'decimal:2', 'min:0.01'],
            'picture' => ['nullable', 'image'],
        ]);

        $recipe = Recipe::findOrFail($id);

        $picture_loc = $recipe->picture;
        if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $hash = hash('sha3-224', $request->file('picture')->path());
            $name = str_replace(' ', '_', $request->file('picture')->getClientOriginalName());
            $request->file('picture')->storeAs('./uploads/', "{$hash}-{$name}", 'public');
            $picture_loc = "/storage/uploads/{$hash}-{$name}";
        }

        $recipe->update([
            'name' => $request->input('name'),
            'description_short' => $request->input('description_short'),
            'allergens' => $request->input('allergens'),
            'price' => $request->input('price'),
            'picture' => $picture_loc,
        ]);

        return redirect('/menu')->with('success', 'Het menu item is aangepast.');
    }

    public function create(Request $request)
    {
        $validator = $request->validate([
            'name' => ['bail', 'required', 'string', 'min:1', 'max:255'],
            'description_short' => ['required', 'min:1', 'max:1024'],
            'allergens' => ['required', 'string', 'min:1'],
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

        return redirect('/menu')->with('success', 'Het menu item is toegevoegd.');
    }

    public function delete(Request $request, int $id)
    {
        $recipe_to_delete = Recipe::find($id);
        if ($recipe_to_delete != null) {
            Recipe::find($id)->delete();

            return redirect('/menu')->with('success', 'Het menu items is verwijderd.');
        } else {
            return redirect('/menu')->withErrors('Het menu item dat verwijderd zou worden bestaat niet!');
        }
    }

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
