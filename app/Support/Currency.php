<?php

namespace App\Support;

class Currency
{
    public static function format(float|int|string|null $amount): string
    {
        return number_format((float) $amount, 0, ',', '.').' Kz';
    }

    public static function symbol(): string
    {
        return 'Kz';
    }
}
