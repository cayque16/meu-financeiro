<?php

namespace Tests\Feature\Core\UseCase\Asset;

use App\Models\Asset;
use App\Models\AssetsType;
use App\Repositories\Eloquent\AssetEloquentRepository;
use App\Repositories\Eloquent\AssetsTypeEloquentRepository;
use Core\UseCase\Asset\CreateAssetUseCase;
use Core\UseCase\DTO\Asset\Create\CreateAssetInputDto;
use Tests\TestCase;

class CreateAssetUseCaseTest extends TestCase
{
    public function testCreate()
    {
        $repoAsset = new AssetEloquentRepository(new Asset());
        $repoAssetType = new AssetsTypeEloquentRepository(new AssetsType());
        $useCase = new CreateAssetUseCase($repoAsset, $repoAssetType);

        $type = AssetsType::factory()->create();

        $response = $useCase->execute(
            new CreateAssetInputDto(
                code: "BTC",
                idType: $type->uuid,
                description: "desc",
            )
        );

        $this->assertNotEmpty($response->id);
        $this->assertEquals("BTC", $response->code);
        $this->assertEquals($type->uuid, $response->idType);
        $this->assertEquals("desc", $response->description);
        $this->assertDatabaseHas('assets', ['uuid' => $response->id]);
    }
}
