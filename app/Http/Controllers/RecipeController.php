<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        return view('recipe.index');
    }

    public function edit(Request $request, Recipe $recipe)
    {
        if ($request->isMethod('GET')) {
            return view('recipe.edit')->with('current_data', $recipe->toArray());
        }

        $request->validate([
            'name' => ['bail', 'required', 'string', 'min:1', 'max:255'],
            'description_short' => ['required', 'min:1', 'max:1024'],
            'allergens' => ['required', 'string', 'min:1'],
            'price' => ['required', 'decimal:2', 'min:0.01'],
            'picture' => ['nullable', 'image'],
        ]);

        $picture_loc = '/storage/';
        if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $picture_loc .= $request->image('picture')->toAvif()->store('images', 'public');
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
            'picture' => ['required', 'image'],
        ]);

        $picture_loc = '/storage/';
        if ($request->file('picture')->isValid()) {
            $picture_loc .= $request->image('picture')->toAvif()->store('images', 'public');
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

    public function delete(Request $request, Recipe $recipe)
    {
        if ($recipe != null) {
            $recipe->delete();

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
        $recipes = Recipe::inRandomOrder()->limit(3)->get();

        return view('welcome', ['recipes' => $recipes]);
    }
}
