<?php

namespace Tests\Feature\Core\UseCase\DividendPayment;

use App\Models\Asset;
use App\Models\DividendPayment;
use App\Repositories\Facades\DividendPaymentRepositoryFacade;
use Core\Domain\Enum\DividendType;
use Core\Domain\ValueObject\Uuid;
use Core\UseCase\DividendPayment\ListDividendsPaymentUseCase;
use Core\UseCase\DTO\DividendPayment\ListDividendsPayment\ListDividendsPaymentInputDto;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class ListDividendsPaymentTest extends TestCase
{
    use DividendPaymentFakersTrait;
    
    private function createUseCase(
        $paymentYear = null,
        $fiscalYear = null,
        $idAsset = null,
        $idType = null
    ) {
        $repository = DividendPaymentRepositoryFacade::createRepository();
        $useCase = new ListDividendsPaymentUseCase($repository);

        return $useCase->execute(new ListDividendsPaymentInputDto($paymentYear, $fiscalYear, $idAsset, $idType));
    }

    public function testListEmpty()
    {
        $response  = $this->createUseCase();

        $this->assertCount(0, $response->items);
    }

    public function testLstDividendsByPaymentYear()
    {
        $this->createFakers();
        DividendPayment::factory()
            ->count(10)
            ->state(new Sequence(
                ['payment_date' => '2024-05-20'],
                ['payment_date' => '2025-05-20'],
            ))
            ->create();

        $result = $this->createUseCase(paymentYear: 2024);

        $this->assertCount(5, $result->items);
    }

    public function testLstDividendsByFiscalYear()
    {
        $this->createFakers();
        DividendPayment::factory()
            ->count(10)
            ->state(new Sequence(
                ['fiscal_year' => 2024],
                ['fiscal_year' => 2025],
            ))
            ->create();

        $result = $this->createUseCase(fiscalYear: 2024);

        $this->assertCount(5, $result->items);
    }

    public function testLstDividendsByIdAsset()
    {
        $this->createFakers();
        $uuid1 = Uuid::random();
        $uuid2 = Uuid::random();
        Asset::factory()->create(['id' => $uuid1]);
        Asset::factory()->create(['id' => $uuid2]);
        DividendPayment::factory()
            ->count(10)
            ->state(new Sequence(
                ['asset_id' => $uuid1],
                ['asset_id' => $uuid2],
            ))
            ->create();

        $result = $this->createUseCase(idAsset: $uuid1);

        $this->assertCount(5, $result->items);
    }

    public function testLstDividendsByType()
    {
        $this->createFakers();
        $type1 = DividendType::JCP;
        $type2 = DividendType::DIVIDENDS;
        DividendPayment::factory()
            ->count(10)
            ->state(new Sequence(
                ['type' => $type1],
                ['type' => $type2],
            ))
            ->create();

        $result = $this->createUseCase(idType: $type1->value);

        $this->assertCount(5, $result->items);
    }

    public function testListsDividendsAllFilters()
    {
        $this->createFakers();
        $id = Uuid::random();
        Asset::factory()->create(['id' => $id]);
        $type = DividendType::JCP;
        DividendPayment::factory()->create([
            'asset_id' => $id,
            'type' => $type,
            'payment_date' => '2024-01-05',
        ]);

        $result = $this->createUseCase(paymentYear: 2024, idAsset: 'id', idType: $type->value);
        $this->assertCount(0, $result->items);
        $result = $this->createUseCase(paymentYear: 2024, idAsset: $id, idType: $type->value);
        $this->assertCount(1, $result->items);
    }
}
