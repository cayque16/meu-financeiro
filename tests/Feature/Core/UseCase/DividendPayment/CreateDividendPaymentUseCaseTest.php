<?php

namespace Tests\Feature\Core\UseCase\DividendPayment;

use App\Models\Asset;
use App\Models\AssetsType;
use App\Models\Currency;
use App\Models\DividendPayment;
use App\Repositories\Eloquent\AssetEloquentRepository;
use App\Repositories\Eloquent\CurrencyEloquentRepository;
use App\Repositories\Eloquent\DividendPaymentEloquentRepository;
use Core\Domain\Enum\DividendType;
use Core\UseCase\DividendPayment\CreateDividendPaymentUseCase;
use Core\UseCase\DTO\DividendPayment\Create\CreateDividendPaymentInputDto;
use Tests\TestCase;

class CreateDividendPaymentUseCaseTest extends TestCase
{
    public function testCreate()
    {
        $repoPayment = new DividendPaymentEloquentRepository(new DividendPayment());
        $repoAsset = new AssetEloquentRepository(new Asset());
        $repoCurrency = new CurrencyEloquentRepository(new Currency());
        $useCase = new CreateDividendPaymentUseCase($repoPayment, $repoAsset, $repoCurrency);

        AssetsType::factory()->create();
        $asset = Asset::factory()->create();
        $currency = Currency::factory()->create();

        $response = $useCase->execute(
            new CreateDividendPaymentInputDto(
                $asset->uuid,
                '2025-05-20',
                DividendType::DIVIDENDS,
                500,
                $currency->id,
            )
        );

        $this->assertNotEmpty($response->id);
        $this->assertEquals($asset->uuid, $response->idAsset);
        $this->assertEquals(DividendType::DIVIDENDS, $response->type);
        $this->assertEquals(500, $response->amount);
        $this->assertEquals($currency->id, $response->idCurrency);
    }
}
