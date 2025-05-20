<?php

namespace App\Providers;

use App\Repositories\Eloquent\AssetsTypeEloquentRepository;
use Core\Domain\Repository\AssetTypeRepositoryInterface;
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
    }
}
