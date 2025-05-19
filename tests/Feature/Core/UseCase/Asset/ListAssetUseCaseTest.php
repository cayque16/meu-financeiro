<?php

namespace Tests\Feature\Core\UseCase\Asset;

use App\Models\Asset;
use App\Models\AssetsType;
use App\Repositories\Eloquent\AssetEloquentRepository;
use Core\UseCase\Asset\ListAssetUseCase;
use Core\UseCase\DTO\Asset\AssetInputDto;
use Tests\TestCase;

class ListAssetUseCaseTest extends TestCase
{
    public function testList()
    {
        $type = AssetsType::factory()->create();
        $asset = Asset::factory()->create();

        $repository = new AssetEloquentRepository(new Asset());
        $useCase = new ListAssetUseCase($repository);

        $response = $useCase->execute(new AssetInputDto(id: $asset->uuid));

        $this->assertEquals($asset->uuid, $response->id);
        $this->assertEquals($asset->codigo, $response->code);
        $this->assertEquals($asset->descricao, $response->description);
        $this->assertEquals($asset->uuid_assets_type, $response->typeId);
        $this->assertEquals($type->uuid, $response->typeId);
    }
}
