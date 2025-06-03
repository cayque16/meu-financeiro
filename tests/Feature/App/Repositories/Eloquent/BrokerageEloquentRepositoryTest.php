<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Brokerage as BrokerageModel;
use Core\Domain\Entity\Brokerage as BrokerageEntity;
use App\Repositories\Eloquent\BrokerageEloquentRepository;
use Core\Domain\Repository\BrokerageRepositoryInterface;
use Core\Domain\ValueObject\Cnpj;
use Core\Domain\ValueObject\Uuid;
use Tests\TestCase;

class BrokerageEloquentRepositoryTest extends TestCase
{
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new BrokerageEloquentRepository(new BrokerageModel());
    }

    public function testImplementsInterface()
    {
        $this->assertInstanceOf(BrokerageRepositoryInterface::class, $this->repository);
    }

    public function testInsert()
    {
        $entity = new BrokerageEntity(
            name: "name",
            webPage: "http://pi.ac/fi",
            cnpj: Cnpj::random(),
        );

        $result = $this->repository->insert($entity);

        $this->assertEquals($entity->id, $result->id);
        $this->assertEquals($entity->name, $result->name);
        $this->assertEquals($entity->webPage, $result->webPage);
        $this->assertEquals($entity->cnpj, (string) $result->cnpj);
    }

    public function testNotFoundFindById()
    {
        $this->assertNull($this->repository->findById(0));
    }

    public function testFindById()
    {
        $brokerage = BrokerageModel::factory()->create();
        
        $result = $this->repository->findById($brokerage->id);

        $this->assertEquals($brokerage->id, $result->id);
        $this->assertEquals($brokerage->name, $result->name);
        $this->assertEquals($brokerage->web_page, $result->webPage);
        $this->assertEquals($brokerage->cnpj, (string) $result->cnpj);
    }

    public function testFindAllEmpty()
    {
        $result = $this->repository->findAll();

        $this->assertCount(0, $result);
    }

    public function testFindAll()
    {
        $count = 10;
        BrokerageModel::factory()->count($count)->create();
        $result = $this->repository->findAll();

        $this->assertCount($count, $result);
        foreach ($result as $item) {
            $this->assertInstanceOf(BrokerageEntity::class, $item);
        }
    }

    public function testUpdateNotFound()
    {
        $entity = new BrokerageEntity(
            id: Uuid::random(),
            name: "Name",
            webPage: "http://zon.tf/cid",
            cnpj: Cnpj::random(),
        );

        $this->assertNull($this->repository->update($entity));
    }

    public function testUpdate()
    {
        $brokerageDb = BrokerageModel::factory()->create([
            "id" => Uuid::random(),
            "name" => "old name",
            "web_page" => "http://muf.eu/zu",
            "cnpj" => Cnpj::random(),
        ]);

        $brokerage = new BrokerageEntity(
            id: $brokerageDb->id,
            name: "new name",
            webPage: $brokerageDb->web_page,
            cnpj: new Cnpj($brokerageDb->cnpj),
        );

        $result = $this->repository->update($brokerage);
        
        $this->assertInstanceOf(BrokerageEntity::class, $result);
        $this->assertEquals("new name", $result->name);
        $this->assertEquals($brokerageDb->web_page, $result->webPage);
        $this->assertEquals($brokerageDb->cnpj, (string) $result->cnpj);
    }

    public function testActivate()
    {
        $typeDb = BrokerageModel::factory()->create([
            'deleted_at' => now(),
        ]);
        
        $this->assertTrue($this->repository->activate($typeDb->id));
    }

    public function testDisable()
    {
        $typeDb = BrokerageModel::factory()->create();
        
        $this->assertTrue($this->repository->disable($typeDb->id));
    }
}
