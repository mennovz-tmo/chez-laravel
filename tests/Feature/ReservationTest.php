<?php

use App\Mail\ReservationCreated;
use App\Models\OpeningDatetime;
use App\Models\Reservation;
use App\Models\User;
use App\Models\WeeklySchedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Spatie\LaravelPdf\Facades\Pdf;

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

test('reservation is allowed at a time that falls only within the special opening times', function () {
    Config::set('app.seats', 50);
    Mail::fake();

    $date = now()->addDays(2)->format('Y-m-d');

    WeeklySchedule::factory()->create([
        'day_of_week' => now()->addDays(2)->format('N') - 1,
        'opening' => '16:00',
        'closing' => '22:00',
    ]);

    OpeningDatetime::factory()->create([
        'date' => $date,
        'opening' => '10:00',
        'closing' => '16:00',
    ]);

    $this->post('/reservation/create', [
        'name' => 'Jesse',
        'amount_of_people' => 2,
        'phone_number' => '0612345678',
        'email' => 'jesse@example.com',
        'date' => $date,
        'arrival' => '13:00',
    ])->assertRedirect('/reservation/create');

    expect(Reservation::count())->toBe(1);
});

test('reservation is rejected outside the special opening times even when within the weekly opening times', function () {
    Config::set('app.seats', 50);
    Mail::fake();

    $date = now()->addDays(2)->format('Y-m-d');

    WeeklySchedule::factory()->create([
        'day_of_week' => now()->addDays(2)->format('N') - 1,
        'opening' => '16:00',
        'closing' => '22:00',
    ]);

    OpeningDatetime::factory()->create([
        'date' => $date,
        'opening' => '10:00',
        'closing' => '16:00',
    ]);

    $this->from('/reservation/create')->post('/reservation/create', [
        'name' => 'Jesse',
        'amount_of_people' => 2,
        'phone_number' => '0612345678',
        'email' => 'jesse@example.com',
        'date' => $date,
        'arrival' => '18:00',
    ])->assertRedirect('/reservation/create')
        ->assertSessionHasErrors();

    expect(Reservation::count())->toBe(0);
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

test('reservation pdf is downloaded', function () {
    Pdf::fake();

    $reservation = Reservation::factory()->create();

    $this->get("/reservation/{$reservation->id}/pdf")->assertOk();

    Pdf::assertRespondedWithPdf(fn ($pdf) => $pdf->isDownload()
        && $pdf->viewName === 'pdf.reservation'
        && $pdf->downloadName === "reservation_{$reservation->number}.pdf");
});
