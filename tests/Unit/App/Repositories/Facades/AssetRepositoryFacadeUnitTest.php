<?php

namespace Tests\Unit\App\Repositories\Facades;

use App\Repositories\Eloquent\AssetEloquentRepository;
use App\Repositories\Facades\AssetRepositoryFacade;

class AssetRepositoryFacadeUnitTest extends FacadesUnitTestCase
{
    protected function getRepositoryClass(): string
    {
        return AssetEloquentRepository::class;
    }

    protected function getFacadeCreateRepository()
    {
        return AssetRepositoryFacade::createRepository();
    }
}
