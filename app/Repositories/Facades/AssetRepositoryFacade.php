<?php

namespace App\Repositories\Facades;

use App\Models\Asset;
use App\Models\AssetsType;
use App\Repositories\Eloquent\AssetEloquentRepository;
use App\Repositories\Eloquent\AssetsTypeEloquentRepository;
use Core\Domain\Repository\AssetRepositoryInterface;

class AssetRepositoryFacade implements RepositoryFacadeInterface
{
    public static function createRepository(): AssetRepositoryInterface
    {
        $model = new Asset();
        $repoAssetType = new AssetsTypeEloquentRepository(new AssetsType());
        $repository = new AssetEloquentRepository($model, $repoAssetType);

        return $repository;
    }
}
