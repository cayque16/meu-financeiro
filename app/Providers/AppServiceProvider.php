<?php

namespace App\Providers;

use App\Presentations\AssetPresentation;
use App\Presentations\CurrencyPresentation;
use App\Presentations\DividendPaymentPresentation;
use App\Repositories\Eloquent\AssetEloquentRepository;
use App\Repositories\Eloquent\AssetsTypeEloquentRepository;
use App\Repositories\Eloquent\BrokerageEloquentRepository;
use App\Repositories\Eloquent\CurrencyEloquentRepository;
use App\Repositories\Eloquent\DividendPaymentEloquentRepository;
use Core\Domain\Presentation\AssetPresentationInterface;
use Core\Domain\Presentation\CurrencyPresentationInterface;
use Core\Domain\Presentation\DividendPaymentPresentationInterface;
use Core\Domain\Repository\AssetRepositoryInterface;
use Core\Domain\Repository\AssetTypeRepositoryInterface;
use Core\Domain\Repository\BrokerageRepositoryInterface;
use Core\Domain\Repository\CurrencyRepositoryInterface;
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
        $this->app->singleton(
            CurrencyRepositoryInterface::class,
            CurrencyEloquentRepository::class
        );
        $this->app->singleton(
            AssetPresentationInterface::class,
            AssetPresentation::class
        );
        $this->app->singleton(
            CurrencyPresentationInterface::class,
            CurrencyPresentation::class
        );
        $this->app->singleton(
            DividendPaymentPresentationInterface::class,
            DividendPaymentPresentation::class
        );
        $this->app->singleton(
            BrokerageRepositoryInterface::class,
            BrokerageEloquentRepository::class
        );
    }
}
