<?php

namespace Tests\Feature\Core\UseCase\DividendPayment;

use App\Models\Asset;
use App\Models\AssetsType;
use App\Models\Currency;
use App\Repositories\Eloquent\CurrencyEloquentRepository;
use App\Repositories\Facades\AssetRepositoryFacade;
use App\Repositories\Facades\DividendPaymentRepositoryFacade;
use Core\Domain\Enum\DividendType;
use Core\Domain\ValueObject\Date;
use Core\UseCase\DividendPayment\CreateDividendPaymentUseCase;
use Core\UseCase\DTO\DividendPayment\Create\CreateDividendPaymentInputDto;
use Tests\TestCase;

class CreateDividendPaymentUseCaseTest extends TestCase
{
    public function testCreate()
    {
        $repoPayment = DividendPaymentRepositoryFacade::createRepository();
        $repoAsset = AssetRepositoryFacade::createRepository();
        $repoCurrency = new CurrencyEloquentRepository(new Currency());
        $useCase = new CreateDividendPaymentUseCase($repoPayment, $repoAsset, $repoCurrency);

        AssetsType::factory()->create();
        $asset = Asset::factory()->create();
        $currency = Currency::factory()->create();

        $response = $useCase->execute(
            new CreateDividendPaymentInputDto(
                $asset->id,
                new Date('2025-05-20'),
                2025,
                DividendType::DIVIDENDS,
                500,
                $currency->id,
            )
        );

        $this->assertNotEmpty($response->id);
        $this->assertEquals($asset->id, $response->idAsset);
        $this->assertEquals(DividendType::DIVIDENDS, $response->type);
        $this->assertEquals(500 * $currency->split, $response->amount);
        $this->assertEquals($currency->id, $response->idCurrency);
    }
}
