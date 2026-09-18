<?php

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    config(['auth.account_creation_enabled' => true]);
});

test('signup creates unverified user and sends verification email', function () {
    Notification::fake();

    $response = $this->post('/auth/register', [
        'name' => 'Test User',
        'email' => 'user@test.com',
        'password' => 'passwordpassword',
        'password_confirmation' => 'passwordpassword',
    ]);

    $response->assertRedirect(route('login'));
    $this->assertGuest();

    $user = User::where('email', 'user@test.com')->first();
    expect($user)->not->toBeNull();
    expect($user->hasVerifiedEmail())->toBeFalse();

    Notification::assertSentTo($user, VerifyEmail::class);
});

test('login authenticates verified user', function () {
    User::factory()->create(['email' => 'login@test.com', 'password' => Hash::make('secret')]);

    $this->post('/auth/login', ['email' => 'login@test.com', 'password' => 'secret'])
        ->assertRedirect('/');
});

test('login sends unverified user to verification notice', function () {
    User::factory()->unverified()->create(['email' => 'login@test.com', 'password' => Hash::make('secret')]);

    $this->post('/auth/login', ['email' => 'login@test.com', 'password' => 'secret'])
        ->assertRedirect(route('verification.notice'));
});

test('unverified user is redirected to verification notice on protected routes', function (string $method, string $url) {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)->call($method, $url)
        ->assertRedirect(route('verification.notice'));
})->with([
    'add opening datetime' => ['POST', '/opening-datetime/create'],
]);

test('staff user can access protected staff routes', function () {
    $user = User::factory()->state(['role' => 'staff'])->create();

    $this->actingAs($user)->get('/recipe')->assertOk();
});

test('unverified user can still view special opening times', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)->get('/opening-datetime')->assertOk();
});

test('user verifies email through the signed link', function () {
    $user = User::factory()->unverified()->create();

    $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
        'id' => $user->id,
        'hash' => sha1($user->email),
    ]);

    $this->actingAs($user)->get($url)->assertRedirect('/');

    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
});

test('verification link with invalid signature is rejected', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)->get("/email/verify/{$user->id}/invalid-hash")
        ->assertForbidden();
});

test('unverified user can resend the verification link', function () {
    Notification::fake();
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)->post(route('verification.send'))->assertRedirect();

    Notification::assertSentTo($user, VerifyEmail::class);
});

test('verified user visiting verification notice is redirected home', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('verification.notice'))->assertRedirect('/');
});
