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

function isOwner(): bool
{
    return auth()->check() && auth()->user()->role === 'owner';
}

function isStaff(): bool
{
    return auth()->check() && (auth()->user()->role === 'owner' || auth()->user()->role === 'staff');
}
