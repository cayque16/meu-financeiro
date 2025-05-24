<?php

namespace App\Providers;

use App\Repositories\Eloquent\AssetEloquentRepository;
use App\Repositories\Eloquent\AssetsTypeEloquentRepository;
use App\Repositories\Eloquent\DividendPaymentEloquentRepository;
use Core\Domain\Repository\AssetRepositoryInterface;
use Core\Domain\Repository\AssetTypeRepositoryInterface;
use Core\Domain\Repository\DividendPaymentRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(
            AssetTypeRepositoryInterface::class,
            AssetsTypeEloquentRepository::class
        );
        $this->app->singleton(
            AssetRepositoryInterface::class,
            AssetEloquentRepository::class
        );
        $this->app->singleton(
            DividendPaymentRepositoryInterface::class,
            DividendPaymentEloquentRepository::class
        );
    }
}
