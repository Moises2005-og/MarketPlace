<?php

use App\Support\Currency;

if (! function_exists('money')) {
    function money(float|int|string|null $amount): string
    {
        return Currency::format($amount);
    }
}
