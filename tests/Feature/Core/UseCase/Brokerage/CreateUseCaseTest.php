<?php

namespace Tests\Feature\Core\UseCase\Brokerage;

use App\Models\Brokerage;
use App\Repositories\Eloquent\BrokerageEloquentRepository;
use Core\Domain\ValueObject\Cnpj;
use Core\UseCase\Brokerage\CreateBrokerageUseCase;
use Core\UseCase\DTO\Brokerage\Create\CreateBrokerageInputDto;
use Tests\TestCase;

class CreateUseCaseTest extends TestCase
{
    public function testCreate()
    {
        $repository = new BrokerageEloquentRepository(new Brokerage());
        $useCase = new CreateBrokerageUseCase($repository);

        $cnpj = Cnpj::random();
        $response = $useCase->execute(
            new CreateBrokerageInputDto(
                name: "name",
                webPage: "http://ok.sg/maw",
                cnpj: $cnpj,
            )
        );

        $this->assertNotEmpty($response->id);
        $this->assertEquals('name', $response->name);
        $this->assertEquals('http://ok.sg/maw', $response->webPage);
        $this->assertEquals($cnpj, (string) $response->cnpj);
        $this->assertDatabaseHas('brokerages', ['id' => $response->id]);
    }
}
