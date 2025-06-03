<?php

namespace App\Repositories\Facades;

use App\Models\Asset;
use App\Models\AssetsType;
use App\Models\Currency;
use App\Models\DividendPayment;
use App\Repositories\Eloquent\AssetEloquentRepository;
use App\Repositories\Eloquent\AssetsTypeEloquentRepository;
use App\Repositories\Eloquent\CurrencyEloquentRepository;
use App\Repositories\Eloquent\DividendPaymentEloquentRepository;

class DividendPaymentRepositoryFacade implements RepositoryFacadeInterface
{
    public static function createRepository(): DividendPaymentEloquentRepository
    {
        $model = new DividendPayment();
        $repoAssetType = new AssetsTypeEloquentRepository(new AssetsType());
        $repoAsset = new AssetEloquentRepository(new Asset(), $repoAssetType);
        $repoCurrency = new CurrencyEloquentRepository(new Currency());
        $repository = new DividendPaymentEloquentRepository($model, $repoAsset, $repoCurrency);

        return $repository;
    }
}