<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Repositories\Eloquent\AssetEloquentRepository;
use App\Models\Asset as AssetModel;
use Core\Domain\Entity\Asset as AssetEntity;
use Core\Domain\Entity\AssetType as AssetTypeEntity;
use App\Models\AssetsType as AssetTypeModel;
use App\Repositories\Eloquent\AssetsTypeEloquentRepository;
use Core\Domain\Repository\BaseRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class AssetEloquentRepositoryTest extends TestCase
{
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new AssetEloquentRepository(new AssetModel());
    }

    public function testImplementsInterface()
    {
        $this->assertInstanceOf(BaseRepositoryInterface::class, $this->repository);
    }

    public function testInsert()
    {
        $typeBd = AssetTypeModel::factory()->create();
        $type = new AssetTypeEntity(
            id: $typeBd->uuid,
            name: $typeBd->nome,
            description: $typeBd->descricao,
            createdAt: $typeBd->created_at,
            oldId: $typeBd->id,
        );

        $asset = new AssetEntity(code: 'BTC', type: $type, description: 'desc');

        $result = $this->repository->insert($asset);

        $this->assertEquals($asset->id, $result->id);
        $this->assertEquals($asset->code, $result->code);
        $this->assertEquals($asset->type->id, $result->type->id);
        $this->assertEquals($asset->type->oldId, $typeBd->id);
        $this->assertEquals($asset->description, $result->description);
    }

    public function testNotFoundFindById()
    {
        $this->assertNull($this->repository->findById(0));
    }

    public function testFindById()
    {
        $typeBd = AssetTypeModel::factory()->create();
        $asset = AssetModel::factory()->create();

        $result = $this->repository->findById($asset->id);

        $this->assertEquals($asset->uuid, $result->id);
        $this->assertEquals($asset->codigo, $result->code);
        $this->assertEquals($asset->uuid_assets_type, $result->type->id);
        $this->assertEquals($asset->id_assets_type, $typeBd->id);
        $this->assertEquals($asset->descricao, $result->description);
    }

     public function testFindAllEmpty()
    {
        $result = $this->repository->findAll();

        $this->assertCount(0, $result);
    }

    public function testFindAll()
    {
        $count = 10;
        AssetTypeModel::factory()->count($count)->create();
        AssetModel::factory()->count($count)->create();
        $result = $this->repository->findAll();

        $this->assertCount($count, $result);
    }

    public function testUpdateNotFound()
    {
        $asset = new AssetEntity(
            id: Uuid::uuid4(),
            code: 'BTC',
            type: new AssetTypeEntity(
                name: 'test',
                description: 'desc',
            ),
            description: 'desc',
        );
        $this->assertNull($this->repository->update($asset));
    }

    public function testUpdate()
    {
        $typeBd = AssetTypeModel::factory()->count(2)->create();
        $assetDb = AssetModel::factory()->create([
            'id' => 1,
            'uuid' => Uuid::uuid4(),
            'codigo' => 'code',
            'id_assets_type' => $typeBd[0]->id,
            'uuid_assets_type' => $typeBd[0]->uuid,
            'e_excluido' => 0,
        ]);

        $asset = new AssetEntity(
            id: $assetDb->uuid,
            code: 'new code',
            type: new AssetTypeEntity(
                id: $typeBd[1]->uuid,
                name: $typeBd[1]->nome,
                description: $typeBd[1]->descricao,
                oldId: $typeBd[1]->id,
            ),
            description: 'new desc',
        );

        $result = $this->repository->update($asset);
        $this->assertInstanceOf(AssetEntity::class, $result);
        $this->assertEquals('new code', $result->code);
        $this->assertEquals('new desc', $result->description);
        $this->assertNotEquals($assetDb->code, $asset->code);
        $this->assertNotEquals($assetDb->id_assets_type, $asset->type->oldId);
    }
}
