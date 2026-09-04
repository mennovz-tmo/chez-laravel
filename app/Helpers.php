<?php

function generate_reservation_number(): string
{
    $reservation_number = "";
    $chars = "0123456789abcdefghijklmnopqrstuvwxyz";
    while (strlen($reservation_number) < 12) {
        $reservation_number .=  $chars[random_int(0, 35)];
    }
    return $reservation_number;
}
