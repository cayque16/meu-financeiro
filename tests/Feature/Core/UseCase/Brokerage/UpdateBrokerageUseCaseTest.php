<?php

namespace Tests\Feature\Core\UseCase\Brokerage;

use App\Models\Brokerage;
use App\Repositories\Eloquent\BrokerageEloquentRepository;
use Core\UseCase\Brokerage\UpdateBrokerageUseCase;
use Core\UseCase\DTO\Brokerage\Update\UpdateBrokerageInputDto;
use Tests\TestCase;

class UpdateBrokerageUseCaseTest extends TestCase
{
    public function testUpdate()
    {
        $brokerage = Brokerage::factory()->create();

        $repository = new BrokerageEloquentRepository(new Brokerage);
        $useCase = new UpdateBrokerageUseCase($repository);

        $response = $useCase->execute(
            new UpdateBrokerageInputDto(
                id: $brokerage->id,
                name: 'new name',
            )
        );

        $this->assertEquals('new name', $response->name);
        $this->assertEquals($brokerage->web_page, $response->webPage);
        $this->assertEquals($brokerage->cnpj, (string) $response->cnpj);
        $this->assertDatabaseHas('brokerages', [
            'name' => $response->name,
        ]);
    }
}
