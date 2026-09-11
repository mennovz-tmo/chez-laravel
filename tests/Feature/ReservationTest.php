<?php

use App\Mail\ReservationCreated;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('guest creates reservation', function () {
    Config::set('app.seats', 50);
    Mail::fake();

    $response = $this->post('/reservation/create', [
        'name' => 'Jesse',
        'amount_of_people' => 2,
        'phone_number' => '0612345678',
        'email' => 'jesse@example.com',
        'date' => now()->addDays(2)->format('Y-m-d'),
        'arrival' => '18:00',
    ]);

    $response->assertRedirect('/reservation/create');
    expect(Reservation::count())->toBe(1);
    Mail::assertSent(ReservationCreated::class);
});

test('reservation view shows by email', function () {
    Reservation::factory()->create(['email' => 'test@test.com']);

    $this->post('/reservation/', ['email' => 'test@test.com'])
        ->assertOk()
        ->assertSee('test@test.com');
});

test('authenticated user sees all reservations', function () {
    $user = User::factory()->create();
    Reservation::factory()->count(3)->create();
    $this->actingAs($user)->get('/reservation')->assertOk();
});
