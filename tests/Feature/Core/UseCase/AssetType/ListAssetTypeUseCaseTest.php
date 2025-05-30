<?php

namespace Tests\Feature\Core\UseCase\AssetType;

use App\Models\AssetsType;
use App\Repositories\Eloquent\AssetsTypeEloquentRepository;
use Core\UseCase\AssetType\ListAssetTypeUseCase;
use Core\UseCase\DTO\AssetType\AssetTypeInputDto;
use Tests\TestCase;

class ListAssetTypeUseCaseTest extends TestCase
{
    public function testList()
    {
        $type = AssetsType::factory()->create();

        $repository = new AssetsTypeEloquentRepository(new AssetsType());
        $useCase = new ListAssetTypeUseCase($repository);

        $response = $useCase->execute(
            new AssetTypeInputDto(id: $type->id)
        );

        $this->assertEquals($type->id, $response->id);
        $this->assertEquals($type->name, $response->name);
        $this->assertEquals($type->description, $response->description);
    }
}
