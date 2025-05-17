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
use Core\Domain\ValueObject\Uuid;
use DateTime;
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
                createdAt: $typeBd->created_at,
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
            date: new DateTime(),
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
}
