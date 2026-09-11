<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user has hidden fields', function () {
    $user = User::factory()->create();
    expect($user->toArray())->not->toHaveKey('password');
});
