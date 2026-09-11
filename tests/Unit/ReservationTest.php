<?php

use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('reservation generates number on create', function () {
    $res = Reservation::factory()->create();
    expect($res->number)->not->toBeNull();
});

test('delete token generates and validates', function () {
    $res = Reservation::factory()->create();
    $token = $res->generateDeleteToken();
    expect($res->hasValidDeleteToken($token))->toBeTrue();
});
