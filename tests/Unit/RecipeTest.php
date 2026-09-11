<?php

use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('recipe fillable fields work', function () {
    $recipe = Recipe::factory()->create();
    expect($recipe->name)->not->toBeEmpty();
});

test('recipe price casts to decimal', function () {
    $recipe = Recipe::factory()->create(['price' => 12.5]);
    expect($recipe->price)->toBe('12.50');
});
