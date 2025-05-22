<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\DividendPayment as DividendPaymentModel;
use Core\Domain\Entity\DividendPayment as DividendPaymentEntity;
use App\Repositories\Eloquent\DividendPaymentEloquentRepository;
use Core\Domain\Entity\Asset as AssetEntity;
use Core\Domain\Entity\AssetType as AssetTypeEntity;
use Core\Domain\Entity\Currency as CurrencyEntity;
use App\Models\Asset as AssetModel;
use App\Models\AssetsType as AssetsTypeModel;
use App\Models\Currency as CurrencyModel;
use Core\Domain\Enum\DividendType;
use Core\Domain\Repository\DividendPaymentRepositoryInterface;
use Core\Domain\ValueObject\Date;
use Core\Domain\ValueObject\Uuid;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class DividendPaymentRepositoryTest extends TestCase
{
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new DividendPaymentEloquentRepository(new DividendPaymentModel());
    }

    public function testImplementsInterface()
    {
        $this->assertInstanceOf(DividendPaymentRepositoryInterface::class, $this->repository);
    }
    public function testInsert()
    {
        $typeBd = AssetsTypeModel::factory()->create();
        $assetBd = AssetModel::factory()->create();
        
        $assetEntity = new AssetEntity(
            id: $assetBd->uuid,
            code: $assetBd->codigo,
            type: new AssetTypeEntity(
                id: $typeBd->uuid,
                name: $typeBd->nome,
                description: $typeBd->descricao,
                createdAt: Date::fromNullable($typeBd->created_at),
                updatedAt: Date::fromNullable($typeBd->updated_at),
                deletedAt: Date::fromNullable($typeBd->deleted_at),
            ),
        );

        $currencyBd = CurrencyModel::factory()->create();
        
        $currencyEntity = new CurrencyEntity(
            'Real',
            'R$',
            'BRL',
            100,
            description: 'desc',
            id: $currencyBd->id
        );

        $payment = new DividendPaymentEntity(
            asset: $assetEntity,
            date: new Date(),
            type: DividendType::DIVIDENDS,
            amount: 1500,
            currency: $currencyEntity,
        );

        $result = $this->repository->insert($payment);

        $this->assertEquals($payment->id, $result->id);
        $this->assertEquals($payment->asset->id, $result->asset->id);
        $this->assertEquals($payment->type, $result->type);
        $this->assertEquals($payment->amount, $result->amount);
        $this->assertEquals($payment->currency->id, $result->currency->id);
    }

    public function testNotFoundFindById()
    {
        $this->assertNull($this->repository->findById(0));
    }

    public function testFindById()
    {
        AssetsTypeModel::factory()->create();
        AssetModel::factory()->create();
        CurrencyModel::factory()->create();
        $payment = DividendPaymentModel::factory()->create();

        $result = $this->repository->findById($payment->id);

        $this->assertEquals($payment->id, $result->id);
        $this->assertEquals($payment->id, $result->id);
        $this->assertEquals($payment->asset->uuid, $result->asset->id);
        $this->assertEquals($payment->type, $result->type);
        $this->assertEquals($payment->amount, $result->amount);
        $this->assertEquals($payment->currency->id, $result->currency->id);
    }

    public function testFindAll()
    {
        $count = 10;
        AssetsTypeModel::factory()->count($count)->create();
        AssetModel::factory()->count($count)->create();
        CurrencyModel::factory()->count($count)->create();
        DividendPaymentModel::factory()->count($count)->create();
        $result = $this->repository->findAll();

        $this->assertCount($count, $result);
    }

    public function testLstDividendsByAno()
    {
        $this->createFakers();
        DividendPaymentModel::factory()
            ->count(10)
            ->state(new Sequence(
                ['date' => '2024-05-20'],
                ['date' => '2025-05-20'],
            ))
            ->create();

        $result = $this->repository->lstDividends(ano: 2024);

        $this->assertCount(5, $result);
    }

    public function testLstDividendsByIdAsset()
    {
        $this->createFakers();
        $uuid1 = Uuid::random();
        $uuid2 = Uuid::random();
        DividendPaymentModel::factory()
            ->count(10)
            ->state(new Sequence(
                ['asset_id' => $uuid1],
                ['asset_id' => $uuid2],
            ))
            ->create();

        $result = $this->repository->lstDividends(idAsset: $uuid1);

        $this->assertCount(5, $result);
    }

    public function testLstDividendsByType()
    {
        $this->createFakers();
        $type1 = DividendType::JCP;
        $type2 = DividendType::DIVIDENDS;
        DividendPaymentModel::factory()
            ->count(10)
            ->state(new Sequence(
                ['type' => $type1],
                ['type' => $type2],
            ))
            ->create();

        $result = $this->repository->lstDividends(idType: $type1->value);

        $this->assertCount(5, $result);
    }

    public function testListsDividendsAllFilters()
    {
        $this->createFakers();
        $uuid = Uuid::random();
        $type = DividendType::JCP;
        DividendPaymentModel::factory()->create([
            'asset_id' => $uuid,
            'type' => $type,
            'date' => '2024-01-05',
        ]);

        $result = $this->repository->lstDividends(ano: 2024, idAsset: 'uuid', idType: $type->value);
        $this->assertCount(0, $result);
        $result = $this->repository->lstDividends(ano: 2024, idAsset: $uuid, idType: $type->value);
        $this->assertCount(1, $result);
    }

    private function createFakers()
    {
        AssetsTypeModel::factory()->create();
        AssetModel::factory()->create();
        CurrencyModel::factory()->create();
    }
}
