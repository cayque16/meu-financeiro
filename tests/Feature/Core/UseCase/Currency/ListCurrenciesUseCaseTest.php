<?php

namespace Tests\Feature\Core\UseCase\Currency;

use App\Models\Currency;
use App\Repositories\Eloquent\CurrencyEloquentRepository;
use Core\UseCase\Currency\ListCurrenciesUseCase;
use Core\UseCase\DTO\Currency\ListCurrencies\ListCurrenciesInputDto;
use Tests\TestCase;

class ListCurrenciesUseCaseTest extends TestCase
{
    public function createUseCase()
    {
        $repository = new CurrencyEloquentRepository(new Currency());
        $useCase = new ListCurrenciesUseCase($repository);

        return $useCase->execute(new ListCurrenciesInputDto());
    }

    public function testListEmpty()
    {
        $response = $this->createUseCase();

        $this->assertCount(0, $response->items);
    }

    public function testListAll()
    {
        $count = 20;
        Currency::factory()->count($count)->create();
        $response = $this->createUseCase();

        $this->assertCount($count, $response->items);
    }
}
