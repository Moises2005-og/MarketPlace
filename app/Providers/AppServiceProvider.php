<?php

namespace App\Providers;

use App\Services\CartService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Password::defaults(fn () => Password::min(8)
            ->letters()
            ->numbers()
            ->mixedCase());

        Paginator::useBootstrapFive();

        View::composer('layouts.app', function ($view) {
            if (app()->runningInConsole()) {
                return;
            }

            $view->with('cartItemCount', app(CartService::class)->getItemCount());
        });
    }
}
