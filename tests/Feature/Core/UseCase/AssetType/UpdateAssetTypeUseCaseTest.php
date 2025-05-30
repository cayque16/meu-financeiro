<?php

namespace Tests\Feature\Core\UseCase\AssetType;

use App\Models\AssetsType;
use App\Repositories\Eloquent\AssetsTypeEloquentRepository;
use Core\UseCase\AssetType\UpdateAssetTypeUseCase;
use Core\UseCase\DTO\AssetType\Update\UpdateAssetTypeInputDto;
use Tests\TestCase;

class UpdateAssetTypeUseCaseTest extends TestCase
{
    public function testUpdate()
    {
        $type = AssetsType::factory()->create();

        $repository = new AssetsTypeEloquentRepository(new AssetsType);
        $useCase = new UpdateAssetTypeUseCase($repository);

        $response = $useCase->execute(
            new UpdateAssetTypeInputDto(
                id: $type->id,
                name: 'new name',
                description: $type->description,
            )
        );

        $this->assertEquals('new name', $response->name);
        $this->assertEquals($type->description, $response->description);
        $this->assertDatabaseHas('assets_type', [
            'name' => $response->name,
        ]);
    }
}
