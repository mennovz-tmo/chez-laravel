<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeCreateRequest;
use App\Http\Requests\RecipeEditRequest;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        return view('recipe.index');
    }

    public function edit(RecipeEditRequest $request, Recipe $recipe)
    {
        if ($request->isMethod('GET')) {
            return view('recipe.edit', compact('recipe'))
                ->with('current_data', $recipe);
        }

        $picture_loc = false;
        if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $picture_loc = '/storage/'.$request
                ->image('picture')
                ->toAvif()
                ->store('images', 'public');
        }

        $data = $request->safe()->except(['picture']);

        if ($picture_loc) {
            $data['picture'] = $picture_loc;
        }

        $recipe->update($data);

        return redirect()
            ->route('menu')
            ->with('success', 'Het menu item is aangepast.');
    }

    public function create(RecipeCreateRequest $request)
    {
        $picture_loc = '/storage/';
        if ($request->file('picture')->isValid()) {
            $picture_loc .= $request
                ->image('picture')
                ->toAvif()
                ->store('images', 'public');
        }

        Recipe::fillAndInsert([
            'name' => $request->validated('name'),
            'description_short' => $request->validated('description_short'),
            'allergens' => $request->validated('allergens'),
            'price' => $request->validated('price'),
            'picture' => $picture_loc,
        ]);

        return redirect()
            ->route('menu')
            ->with('success', 'Het menu item is toegevoegd.');
    }

    public function delete(Request $request, Recipe $recipe)
    {
        $recipe->delete();

        return redirect()
            ->route('menu')
            ->with('success', 'Het menu items is verwijderd.');
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
