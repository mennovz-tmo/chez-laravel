<?php

use App\Models\OpeningDatetime;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('staff can create special opening times', function () {
    $user = User::factory()->state(['role' => 'staff'])->create();

    $this->actingAs($user)
        ->post('/opening-datetime/create', [
            'date' => now()->addDays(10)->format('Y-m-d'),
            'open' => 1,
            'opening' => '10:00',
            'closing' => '22:00',
        ])
        ->assertRedirect('/opening-datetime');

    expect(OpeningDatetime::count())->toBe(1);
});

test('consumer cannot create special opening times', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post('/opening-datetime/create', [
            'date' => now()->addDays(10)->format('Y-m-d'),
            'open' => 1,
            'opening' => '10:00',
            'closing' => '22:00',
        ])
        ->assertForbidden();

    expect(OpeningDatetime::count())->toBe(0);
});

test('staff can edit special opening times', function () {
    $user = User::factory()->state(['role' => 'staff'])->create();
    $openingDatetime = OpeningDatetime::factory()->create();

    $this->actingAs($user)
        ->post("/opening-datetime/{$openingDatetime->id}/edit", [
            'date' => $openingDatetime->date->format('Y-m-d'),
            'open' => 1,
            'opening' => '12:00',
            'closing' => '20:00',
        ])
        ->assertRedirect('/opening-datetime');

    expect($openingDatetime->fresh()->opening->format('H:i'))->toBe('12:00');
});

test('consumer cannot edit special opening times', function () {
    $user = User::factory()->create();
    $openingDatetime = OpeningDatetime::factory()->create();

    $this->actingAs($user)
        ->get("/opening-datetime/{$openingDatetime->id}/edit")
        ->assertRedirect('/');
});

test('staff can delete special opening times', function () {
    $user = User::factory()->state(['role' => 'staff'])->create();
    $openingDatetime = OpeningDatetime::factory()->create();

    $this->actingAs($user)
        ->get("/opening-datetime/{$openingDatetime->id}/delete")
        ->assertRedirect('/opening-datetime');

    expect(OpeningDatetime::find($openingDatetime->id))->toBeNull();
});

test('consumer cannot delete special opening times', function () {
    $user = User::factory()->create();
    $openingDatetime = OpeningDatetime::factory()->create();

    $this->actingAs($user)
        ->get("/opening-datetime/{$openingDatetime->id}/delete")
        ->assertRedirect('/');

    expect(OpeningDatetime::find($openingDatetime->id))->not->toBeNull();
});
