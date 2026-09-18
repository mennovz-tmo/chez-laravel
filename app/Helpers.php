<?php

function generate_reservation_number(): string
{
    $reservation_number = '';
    $chars = '0123456789abcdefghijklmnopqrstuvwxyz-_';
    while (strlen($reservation_number) < 20) {
        $reservation_number .= $chars[random_int(0, 35)];
    }

    return $reservation_number;
}

function is_owner(): bool
{
    return auth()->check() && auth()->user()->role === 'owner';
}

function is_staff(): bool
{
    return auth()->check() && (auth()->user()->role === 'owner' || auth()->user()->role === 'staff');
}
