<?php

namespace Tests\Feature\Core\UseCase\Asset;

use App\Models\Asset;
use App\Models\AssetsType;
use App\Repositories\Eloquent\AssetEloquentRepository;
use Core\UseCase\Asset\ListAssetsUseCase;
use Core\UseCase\DTO\Asset\ListAssets\ListAssetsInputDto;
use Tests\TestCase;

class ListAssetsUseCaseTest extends TestCase
{
    private function createUseCase()
    {
        $repository = new AssetEloquentRepository(new Asset());
        $useCase = new ListAssetsUseCase($repository);

        return $useCase->execute(new ListAssetsInputDto());
    }

    public function testListEmpty()
    {
        $response  = $this->createUseCase();

        $this->assertCount(0, $response->items);
    }

    public function testListAll()
    {
        $count = 20;
        AssetsType::factory()->count($count)->create();
        Asset::factory()->count($count)->create();
        $response = $this->createUseCase();

        $this->assertCount($count, $response->items);
    }
}
