<?php

use App\Models\OpeningDatetime;
use App\Models\Recipe;
use App\Models\Reservation;
use App\Models\User;
use App\Models\WeeklySchedule;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('statistics page loads with all sections', function () {
    $user = User::factory()->create(['role' => 'staff']);

    $this->actingAs($user)->get(route('statistics'))
        ->assertStatus(200)
        ->assertSee('Statistieken')
        ->assertSee('Reserveringen')
        ->assertSee('Openingstijden')
        ->assertSee('Recepten');
});

test('statistics page shows aggregated reservation and recipe data', function () {
    $user = User::factory()->create(['role' => 'staff']);

    Reservation::factory()->create([
        'date' => now()->toDateString(),
        'arrival' => '18:00',
        'amount_of_people' => 4,
    ]);
    Recipe::factory()->create(['name' => 'Test Burger', 'price' => 12.50, 'allergens' => 'gluten']);
    OpeningDatetime::factory()->create(['date' => now()->toDateString(), 'open' => true]);
    WeeklySchedule::factory()->create(['day_of_week' => 0, 'is_open' => true]);

    $this->actingAs($user)->get(route('statistics'))
        ->assertStatus(200)
        ->assertSee('Test Burger')
        ->assertSee('reservations-per-day')
        ->assertSee('arrivals-by-hour')
        ->assertSee('recipe-prices');
});
