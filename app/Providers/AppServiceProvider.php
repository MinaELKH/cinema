<?php

namespace App\Providers;

use App\Repositories\Contracts\SalleRepositoryInterface;
use App\Repositories\Contracts\SiegeRepositoryInterface;
use App\Repositories\SalleRepository;
use App\Repositories\FilmRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(SalleRepositoryInterface::class, SalleRepository::class);
        $this->app->bind(SiegeRepositoryInterface::class, SiegeRepository::class);
        $this->app->bind(FilmRepositoryInterface::class, FilmRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
