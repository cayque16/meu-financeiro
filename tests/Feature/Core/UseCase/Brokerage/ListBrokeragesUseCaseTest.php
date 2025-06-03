<?php

namespace Tests\Feature\Core\UseCase\Brokerage;

use App\Models\Brokerage;
use App\Repositories\Eloquent\BrokerageEloquentRepository;
use Core\UseCase\Brokerage\ListBrokeragesUseCase;
use Core\UseCase\DTO\Brokerage\ListBrokerages\ListBrokeragesInputDto;
use Tests\TestCase;

class ListBrokeragesUseCaseTest extends TestCase
{
    private function createUseCase()
    {
        $repository = new BrokerageEloquentRepository(new Brokerage());
        $useCase = new ListBrokeragesUseCase($repository);

        return $useCase->execute(new ListBrokeragesInputDto());
    }

    public function testListEmpty()
    {
        $response = $this->createUseCase();
        $this->assertCount(0, $response->items);
    }

    public function testListAll()
    {
        $count = 20;
        Brokerage::factory()->count($count)->create();
        $response = $this->createUseCase();

        $this->assertCount($count, $response->items);
    }
}
