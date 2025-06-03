<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Asset as AssetModel;
use Core\Domain\Entity\Asset as AssetEntity;
use Core\Domain\Entity\AssetType as AssetTypeEntity;
use App\Models\AssetsType as AssetTypeModel;
use App\Repositories\Facades\AssetRepositoryFacade;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\Domain\ValueObject\Date;
use Core\Domain\ValueObject\Uuid;
use Tests\TestCase;

class AssetEloquentRepositoryTest extends TestCase
{
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = AssetRepositoryFacade::createRepository();
    }

    public function testImplementsInterface()
    {
        $this->assertInstanceOf(BaseRepositoryInterface::class, $this->repository);
    }

    public function testInsert()
    {
        $typeBd = AssetTypeModel::factory()->create();
        // dd($typeBd);
        $type = new AssetTypeEntity(
            id: $typeBd->id,
            name: $typeBd->name,
            description: $typeBd->description,
            createdAt: new Date($typeBd->created_at),
        );

        $asset = new AssetEntity(code: 'BTC', type: $type, description: 'desc');

        $result = $this->repository->insert($asset);

        $this->assertEquals($asset->id, $result->id);
        $this->assertEquals($asset->code, $result->code);
        $this->assertEquals($asset->type->id, $result->type->id);
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

        $this->assertEquals($asset->id, $result->id);
        $this->assertEquals($asset->code, $result->code);
        $this->assertEquals($asset->assets_type_id, $result->type->id);
        $this->assertEquals($asset->description, $result->description);
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
        foreach ($result as $item) {
            $this->assertInstanceOf(AssetEntity::class, $item);
        }
    }

    public function testUpdateNotFound()
    {
        $asset = new AssetEntity(
            id: Uuid::random(),
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
            'id' => Uuid::random(),
            'code' => 'code',
            'assets_type_id' => $typeBd[0]->id,
        ]);

        $asset = new AssetEntity(
            id: $assetDb->id,
            code: 'new code',
            type: new AssetTypeEntity(
                id: $typeBd[1]->id,
                name: $typeBd[1]->name,
                description: $typeBd[1]->description,
            ),
            description: 'new desc',
        );

        $result = $this->repository->update($asset);
        $this->assertInstanceOf(AssetEntity::class, $result);
        $this->assertEquals('new code', $result->code);
        $this->assertEquals('new desc', $result->description);
        $this->assertNotEquals($assetDb->code, $asset->code);
    }

    public function testActivate()
    {
        AssetTypeModel::factory()->create();
        $assetDb = AssetModel::factory()->create([
            'deleted_at' => now(),
        ]);

        $this->assertTrue($this->repository->activate($assetDb->id));
    }

    public function testDisable()
    {
        AssetTypeModel::factory()->create();
        $assetDb = AssetModel::factory()->create();

        $this->assertTrue($this->repository->disable($assetDb->id));
    }
}
