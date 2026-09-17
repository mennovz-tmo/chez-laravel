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
            return view('recipe.edit', compact('recipe'))
                ->with('current_data', $recipe);
        }

        $request->validate([
            'name' => ['bail', 'required', 'string', 'min:1', 'max:255'],
            'description_short' => ['required', 'min:1', 'max:1024'],
            'allergens' => ['required', 'string', 'min:1'],
            'price' => ['required', 'decimal:2', 'min:0.01'],
            'picture' => ['nullable', 'image'],
        ]);

        $picture_loc = false;
        if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $picture_loc = '/storage/'.$request
                ->image('picture')
                ->toAvif()
                ->store('images', 'public');
        }

        $data = [
            'name' => $request->input('name'),
            'description_short' => $request->input('description_short'),
            'allergens' => $request->input('allergens'),
            'price' => $request->input('price'),
        ];

        if ($picture_loc) {
            $data['picture'] = $picture_loc;
        }

        $recipe->update($data);

        return redirect()
            ->route('menu')
            ->with('success', 'Het menu item is aangepast.');
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
            $picture_loc .= $request
                ->image('picture')
                ->toAvif()
                ->store('images', 'public');
        }

        Recipe::fillAndInsert([
            'name' => $request->input('name'),
            'description_short' => $request->input('description_short'),
            'allergens' => $request->input('allergens'),
            'price' => $request->input('price'),
            'picture' => $picture_loc,
        ]);

        return redirect()
            ->route('menu')
            ->with('success', 'Het menu item is toegevoegd.');
    }

    public function delete(Request $request, Recipe $recipe)
    {
        if ($recipe != null) {
            $recipe->delete();

            return redirect()
                ->route('menu')
                ->with('success', 'Het menu items is verwijderd.');
        }

        return redirect()
            ->route('menu')
            ->withErrors('Het menu item dat verwijderd zou worden bestaat niet!');
    }

    public function menu()
    {
        $recipes = Recipe::get();

        return view('menu.index', compact('recipes'));
    }

    public function welcome()
    {
        $recipes = Recipe::inRandomOrder()->limit(3)->get();

        return view('welcome', compact('recipes'));
    }
}
