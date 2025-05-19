<?php

namespace Tests\Feature\Core\UseCase\AssetType;

use App\Models\AssetsType;
use App\Repositories\Eloquent\AssetsTypeEloquentRepository;
use Core\UseCase\AssetType\ListAssetsTypesUseCase;
use Core\UseCase\DTO\AssetType\ListAssetsTypes\ListAssetsTypesInputDto;
use Tests\TestCase;

class ListAssetsTypesUseCaseTest extends TestCase
{
    private function createUseCase()
    {
        $repository = new AssetsTypeEloquentRepository(new AssetsType());
        $useCase = new ListAssetsTypesUseCase($repository);

        return $useCase->execute(new ListAssetsTypesInputDto());
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
        $response = $this->createUseCase();

        $this->assertCount($count, $response->items);
    }
}
