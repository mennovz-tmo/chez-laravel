<?php

use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('welcome loads', function () {
    $this->get('/')->assertStatus(200);
});

test('menu loads with recipes', function () {
    Recipe::factory()->create(['name' => 'Soup']);
    $this->get('/menu')->assertStatus(200)->assertSee('Soup');
});
