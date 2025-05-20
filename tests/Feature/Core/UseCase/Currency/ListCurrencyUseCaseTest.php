<?php

namespace Tests\Feature\Core\UseCase\Currency;

use App\Models\Currency;
use App\Repositories\Eloquent\CurrencyEloquentRepository;
use Core\UseCase\Currency\ListCurrencyUseCase;
use Core\UseCase\DTO\Currency\CurrencyInputDto;
use Tests\TestCase;

class ListCurrencyUseCaseTest extends TestCase
{
    public function testList()
    {
        $currency = Currency::factory()->create();

        $repository = new CurrencyEloquentRepository(new Currency());
        $useCase = new ListCurrencyUseCase($repository);

        $response = $useCase->execute(
            new CurrencyInputDto($currency->id)
        );

        $this->assertEquals($currency->id, $response->id);
        $this->assertEquals($currency->name, $response->name);
        $this->assertEquals($currency->symbol, $response->symbol);
        $this->assertEquals($currency->iso_code, $response->isoCode);
        $this->assertEquals($currency->split, $response->split);
        $this->assertEquals($currency->decimals, $response->decimals);  
        $this->assertEquals($currency->description, $response->description);
    }
}
                