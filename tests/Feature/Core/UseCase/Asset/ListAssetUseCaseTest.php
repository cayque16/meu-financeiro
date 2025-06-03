<?php

namespace Tests\Feature\Core\UseCase\Asset;

use App\Models\Asset;
use App\Models\AssetsType;
use App\Repositories\Facades\AssetRepositoryFacade;
use Core\UseCase\Asset\ListAssetUseCase;
use Core\UseCase\DTO\Asset\AssetInputDto;
use Tests\TestCase;

class ListAssetUseCaseTest extends TestCase
{
    public function testList()
    {
        $type = AssetsType::factory()->create();
        $asset = Asset::factory()->create();

        $repository = AssetRepositoryFacade::createRepository();
        $useCase = new ListAssetUseCase($repository);

        $response = $useCase->execute(new AssetInputDto(id: $asset->id));

        $this->assertEquals($asset->id, $response->id);
        $this->assertEquals($asset->code, $response->code);
        $this->assertEquals($asset->description, $response->description);
        $this->assertEquals($asset->assets_type_id, $response->typeId);
        $this->assertEquals($type->id, $response->typeId);
    }
}
