<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Currency as CurrencyModel;
use Core\Domain\Entity\Currency as CurrencyEntity;
use App\Repositories\Eloquent\CurrencyEloquentRepository;
use Core\Domain\Repository\BaseRepositoryInterface;
use Tests\TestCase;

class CurrencyEloquentRepositoryTest extends TestCase
{
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new CurrencyEloquentRepository(new CurrencyModel());
    }

    public function testImplementsInterface()
    {
        $this->assertInstanceOf(BaseRepositoryInterface::class, $this->repository);
    }

    public function testInsert()
    {
        $entity = new CurrencyEntity(
            name: "Real",
            symbol: "R$",
            isoCode: "BRL",
            split: 100,
            description: "desc",
        );

        $result = $this->repository->insert($entity);

        $this->assertEquals($entity->id, $result->id);
        $this->assertEquals($entity->name, $result->name);
        $this->assertEquals($entity->symbol, $result->symbol);
        $this->assertEquals($entity->isoCode, $result->isoCode);
        $this->assertEquals($entity->split, $result->split);
        $this->assertEquals($entity->decimals, $result->decimals);
        $this->assertEquals($entity->description, $result->description);
        $this->assertDatabaseHas("currencies", [
            "id" => $entity->id(),
        ]);
    }

    public function testNotFoundFindById()
    {
        $this->assertNull($this->repository->findById(0));
    }

    public function testFindById()
    {
        $currency = CurrencyModel::factory()->create();
        
        $result = $this->repository->findById($currency->id);

        $this->assertEquals($currency->id, $result->id);
        $this->assertEquals($currency->name, $result->name);
        $this->assertEquals($currency->symbol, $result->symbol);
        $this->assertEquals($currency->iso_code, $result->isoCode);
        $this->assertEquals($currency->split, $result->split);
        $this->assertEquals($currency->decimals, $result->decimals);
        $this->assertEquals($currency->description, $result->description);
    }

    public function testFindAllEmpty()
    {
        $result = $this->repository->findAll();

        $this->assertCount(0, $result);
    }

    public function testFindAll()
    {
        $count = 10;
        CurrencyModel::factory()->count($count)->create();
        $result = $this->repository->findAll();

        $this->assertCount($count, $result);
    }
}
