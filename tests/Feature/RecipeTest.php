<?php

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

test('guest sees welcome', function () {
    $this->get('/')->assertOk()->assertSee('Chez Laravel');
});

test('guest sees menu', function () {
    Recipe::factory()->count(2)->create();
    $this->get('/menu')->assertOk()->assertSee('Menu');
});

test('auth user creates recipe', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/recipe/create', [
        'name' => 'Steak',
        'description_short' => 'Tasty',
        'allergens' => 'Gluten',
        'price' => '22.50',
        'picture' => UploadedFile::fake()->image('dish.jpg'),
    ]);

    $response->assertRedirect('/menu');
    expect(Recipe::where('name', 'Steak')->exists())->toBeTrue();
});

test('recipe edit updates data', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create();
    $this->actingAs($user);

    $this->post("/recipe/{$recipe->id}/edit", [
        'name' => 'Updated',
        'description_short' => 'New desc',
        'allergens' => 'None',
        'price' => '15.00',
    ])->assertRedirect('/menu');

    expect(Recipe::find($recipe->id)->name)->toBe('Updated');
});

test('recipe delete removes record', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create();
    $this->actingAs($user);

    $this->get("/recipe/{$recipe->id}/delete")->assertRedirect('/menu');
    expect(Recipe::find($recipe->id))->toBeNull();
});
