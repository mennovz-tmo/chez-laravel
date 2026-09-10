<?php

use App\Mail\ReservationDeleteRequested;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

function deletableReservation(array $overrides = []): Reservation
{
    return Reservation::factory()->create(array_merge([
        'date' => now()->addDays(5)->format('Y-m-d'),
        'arrival' => '18:00',
        'departure' => '20:00',
    ], $overrides));
}

test('guest delete request sends verification email and keeps reservation', function () {
    Mail::fake();

    $reservation = deletableReservation();

    $response = $this->get("/reservation/{$reservation->id}/delete");

    $response->assertOk();
    $response->assertViewIs('reservation.delete');
    expect(Reservation::find($reservation->id))->not->toBeNull();

    Mail::assertSent(ReservationDeleteRequested::class, fn ($mail) => $mail->hasTo($reservation->email));
});

test('guest confirms deletion with valid token from email', function () {
    Mail::fake();

    $reservation = deletableReservation();
    $this->get("/reservation/{$reservation->id}/delete");

    $plainToken = null;
    Mail::assertSent(ReservationDeleteRequested::class, function ($mail) use (&$plainToken, $reservation) {
        if ($mail->hasTo($reservation->email)) {
            $plainToken = $mail->deleteToken;

            return true;
        }

        return false;
    });
    expect($plainToken)->not->toBeNull();

    // Only the hash may be stored, never the plaintext token.
    expect($reservation->fresh()->delete_token)->toBe(hash('sha256', $plainToken));

    $response = $this->get("/reservation/{$reservation->id}/delete/{$plainToken}");

    $response->assertRedirect('/reservation');
    expect(Reservation::find($reservation->id))->toBeNull();
});

test('guest cannot delete with invalid token', function () {
    $reservation = deletableReservation();
    $reservation->generateDeleteToken();

    $response = $this->get("/reservation/{$reservation->id}/delete/invalid-token");

    $response->assertRedirect('/reservation');
    expect(Reservation::find($reservation->id))->not->toBeNull();
});

test('expired token does not delete and is cleared', function () {
    $reservation = deletableReservation();
    $plainToken = $reservation->generateDeleteToken();
    $reservation->forceFill(['delete_token_expires_at' => now()->subHour()])->save();

    $response = $this->get("/reservation/{$reservation->id}/delete/{$plainToken}");

    $response->assertRedirect('/reservation');
    expect(Reservation::find($reservation->id))->not->toBeNull();
    expect($reservation->fresh()->delete_token)->toBeNull();
});

test('authenticated user deletes immediately without email', function () {
    Mail::fake();

    $user = User::factory()->create();
    $reservation = deletableReservation();

    $response = $this->actingAs($user)->get("/reservation/{$reservation->id}/delete");

    $response->assertRedirect('/reservation');
    expect(Reservation::find($reservation->id))->toBeNull();
    Mail::assertNotSent(ReservationDeleteRequested::class);
});
