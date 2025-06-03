<?php

namespace Tests\Feature\Core\UseCase\Brokerage;

use App\Models\Brokerage;
use App\Repositories\Eloquent\BrokerageEloquentRepository;
use Core\UseCase\Brokerage\ListBrokerageUseCase;
use Core\UseCase\DTO\Brokerage\BrokerageInputDto;
use Tests\TestCase;

class ListBrokerageUseCaseTest extends TestCase
{
    public function testList()
    {
        $brokerage = Brokerage::factory()->create();

        $repository = new BrokerageEloquentRepository(new Brokerage());
        $useCase = new ListBrokerageUseCase($repository);

        $response = $useCase->execute(new BrokerageInputDto(id: $brokerage->id));

        $this->assertEquals($brokerage->id, $response->id);
        $this->assertEquals($brokerage->name, $response->name);
        $this->assertEquals($brokerage->web_page, $response->webPage);
        $this->assertEquals($brokerage->cnpj, (string) $response->cnpj);
    }
}
