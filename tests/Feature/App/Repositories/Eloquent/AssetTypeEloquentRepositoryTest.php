<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Repositories\Eloquent\AssetsTypeEloquentRepository;
use Tests\TestCase;
use App\Models\AssetsType as AssetTypeModel;
use Core\Domain\Entity\AssetType as AssetTypeEntity;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\Domain\ValueObject\Uuid;

class AssetTypeEloquentRepositoryTest extends TestCase
{
    protected $repository;
    
    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new AssetsTypeEloquentRepository(new AssetTypeModel());
    }

    public function testImplementsInterface()
    {
        $this->assertInstanceOf(BaseRepositoryInterface::class, $this->repository); 
    }

    public function testInsert()
    {
        $entity = new AssetTypeEntity(
            name: "stock",
            description: "desc",
        );

        $result = $this->repository->insert($entity);

        $this->assertEquals($entity->id, $result->id);
        $this->assertEquals($entity->name, $result->name);
        $this->assertEquals($entity->description, $result->description);
    }

    public function testNotFoundFindById()
    {
        $this->assertNull($this->repository->findById(0));
    }

    public function testFindById()
    {
        $typeBd = AssetTypeModel::factory()->create();

        $result = $this->repository->findById($typeBd->id);

        $this->assertEquals($typeBd->id, $result->id);
        $this->assertEquals($typeBd->name, $result->name);
        $this->assertEquals($typeBd->description, $result->description);
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
        $result = $this->repository->findAll();

        $this->assertCount($count, $result);
        foreach ($result as $item) {
            $this->assertInstanceOf(AssetTypeEntity::class, $item);
        }
    }

    public function testUpdateNotFound()
    {
        $entity = new AssetTypeEntity(
            id: Uuid::random(),
            name: "stock",
            description: "desc",
        );

        $this->assertNull($this->repository->update($entity));
    }

    public function testUpdate()
    {
        $typeDb = AssetTypeModel::factory()->create([
            "id" => Uuid::random(),
            "name" => "old name",
            "description" => "old desc",
        ]);

        $type = new AssetTypeEntity(
            id: $typeDb->id,
            name: 'new name',
            description: 'new desc',
        );

        $result = $this->repository->update($type);
        $this->assertInstanceOf(AssetTypeEntity::class, $result);
        $this->assertEquals('new name', $result->name);
        $this->assertEquals('new desc', $result->description);
        $this->assertNotEquals($typeDb->name, $result->name);
        $this->assertNotEquals($typeDb->description, $result->description);
    }

    public function testActivate()
    {
        $typeDb = AssetTypeModel::factory()->create([
            'deleted_at' => now(),
        ]);
        
        $this->assertTrue($this->repository->activate($typeDb->id));
    }

    public function testDisable()
    {
        $typeDb = AssetTypeModel::factory()->create();
        
        $this->assertTrue($this->repository->disable($typeDb->id));
    }
}
