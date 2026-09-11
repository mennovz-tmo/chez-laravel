<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('signup creates user', function () {
    $response = $this->post('/auth/register', [
        'name' => 'Test User',
        'email' => 'user@test.com',
        'password' => 'passwordpassword',
        'password_confirmation' => 'passwordpassword',
    ]);
    $response->assertRedirect();
    expect(User::where('email', 'user@test.com')->exists())->toBeTrue();
});

test('login authenticates', function () {
    User::factory()->create(['email' => 'login@test.com', 'password' => bcrypt('secret')]);

    $this->post('/auth/login', ['email' => 'login@test.com', 'password' => 'secret'])
        ->assertRedirect();
});
