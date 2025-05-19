<?php

namespace Tests\Feature\Core\UseCase\Asset;

use App\Models\Asset;
use App\Models\AssetsType;
use App\Repositories\Eloquent\AssetEloquentRepository;
use App\Repositories\Eloquent\AssetsTypeEloquentRepository;
use Core\UseCase\Asset\UpdateAssetUseCase;
use Core\UseCase\DTO\Asset\Update\UpdateAssetInputDto;
use Tests\TestCase;

class UpdateAssetUseCaseTest extends TestCase
{
    public function testUpdate()
    {
        AssetsType::factory()->create();
        $asset = Asset::factory()->create();
        $newType = AssetsType::factory()->create();

        $repoAsset = new AssetEloquentRepository(new Asset());
        $repoAssetType = new AssetsTypeEloquentRepository(new AssetsType());
        $useCase = new UpdateAssetUseCase($repoAsset, $repoAssetType);

        $response = $useCase->execute(
            new UpdateAssetInputDto(
                id: $asset->uuid,
                code: 'new code',
                idType: $newType->uuid,
                description: 'new desc',
            )
        );

        $this->assertEquals('new code', $response->code);
        $this->assertEquals('new desc', $response->description);
        $this->assertEquals($newType->uuid, $response->idType);
        $this->assertDatabaseHas('assets', [
            'codigo' => $response->code,
        ]);
    }
}
