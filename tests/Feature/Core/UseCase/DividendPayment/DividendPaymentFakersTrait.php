<?php

namespace Tests\Feature\Core\UseCase\DividendPayment;

use App\Models\Asset;
use App\Models\AssetsType;
use App\Models\Currency;

trait DividendPaymentFakersTrait
{
    private function createFakers()
    {
        AssetsType::factory()->create();
        Asset::factory()->create();
        Currency::factory()->create();
    }
}
