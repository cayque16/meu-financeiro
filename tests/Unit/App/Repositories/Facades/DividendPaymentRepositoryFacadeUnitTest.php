<?php

namespace Tests\Unit\App\Repositories\Facades;

use App\Repositories\Eloquent\DividendPaymentEloquentRepository;
use App\Repositories\Facades\DividendPaymentRepositoryFacade as FacadesDividendPaymentRepositoryFacade;

class DividendPaymentRepositoryFacadeUnitTest extends FacadesUnitTestCase
{
    protected function getRepositoryClass(): string
    {
        return DividendPaymentEloquentRepository::class;
    }

    protected function getFacadeCreateRepository()
    {
        return FacadesDividendPaymentRepositoryFacade::createRepository();
    }
}
