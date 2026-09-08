<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// PENTING: Tambahkan baris import ini
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // PENTING: Tambahkan baris ini agar pagination menggunakan Bootstrap 5
        Paginator::useBootstrapFive();
    }
}