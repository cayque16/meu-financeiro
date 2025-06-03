<?php

namespace Tests\Feature\Core\UseCase\Asset;

use App\Models\AssetsType;
use App\Repositories\Eloquent\AssetsTypeEloquentRepository;
use App\Repositories\Facades\AssetRepositoryFacade;
use Core\UseCase\Asset\CreateAssetUseCase;
use Core\UseCase\DTO\Asset\Create\CreateAssetInputDto;
use Tests\TestCase;

class CreateAssetUseCaseTest extends TestCase
{
    public function testCreate()
    {
        $repoAsset = AssetRepositoryFacade::createRepository();
        $repoAssetType = new AssetsTypeEloquentRepository(new AssetsType());
        $useCase = new CreateAssetUseCase($repoAsset, $repoAssetType);

        $type = AssetsType::factory()->create();

        $response = $useCase->execute(
            new CreateAssetInputDto(
                code: "BTC",
                idType: $type->id,
                description: "desc",
            )
        );

        $this->assertNotEmpty($response->id);
        $this->assertEquals("BTC", $response->code);
        $this->assertEquals($type->id, $response->idType);
        $this->assertEquals("desc", $response->description);
        $this->assertDatabaseHas('assets', ['id' => $response->id]);
    }
}
