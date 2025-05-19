<?php

namespace Tests\Feature\Core\UseCase\AssetType;

use App\Models\AssetsType;
use App\Repositories\Eloquent\AssetsTypeEloquentRepository;
use Core\UseCase\AssetType\CreateAssetTypeUseCase;
use Core\UseCase\DTO\AssetType\Create\CreateAssetTypeInputDto;
use Tests\TestCase;

class CreateAssetTypeUseCaseTest extends TestCase
{
    public function testCreate()
    {
        $repository = new AssetsTypeEloquentRepository(new AssetsType());
        $useCase = new CreateAssetTypeUseCase($repository);
        
        $response = $useCase->execute(
            new CreateAssetTypeInputDto(
                'name',
                'desc'
            )
        );

        $this->assertNotEmpty($response->id);
        $this->assertEquals('name', $response->name);
        $this->assertEquals('desc', $response->description);
        $this->assertDatabaseHas('assets_types', ['uuid' => $response->id]);
    }
}
