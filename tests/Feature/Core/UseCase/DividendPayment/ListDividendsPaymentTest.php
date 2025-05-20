<?php

namespace Tests\Feature\Core\UseCase\DividendPayment;

use App\Models\DividendPayment;
use App\Repositories\Eloquent\DividendPaymentEloquentRepository;
use Core\Domain\Enum\DividendType;
use Core\Domain\ValueObject\Uuid;
use Core\UseCase\DividendPayment\ListDividendsPaymentUseCase;
use Core\UseCase\DTO\DividendPayment\ListDividendsPayment\ListDividendsPaymentInputDto;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class ListDividendsPaymentTest extends TestCase
{
    use DividendPaymentFakersTrait;
    
    private function createUseCase($ano = null, $idAsset = null, $idType = null)
    {
        $repository = new DividendPaymentEloquentRepository(new DividendPayment());
        $useCase = new ListDividendsPaymentUseCase($repository);

        return $useCase->execute(new ListDividendsPaymentInputDto($ano, $idAsset, $idType));
    }

    public function testListEmpty()
    {
        $response  = $this->createUseCase();

        $this->assertCount(0, $response->items);
    }

    public function testLstDividendsByAno()
    {
        $this->createFakers();
        DividendPayment::factory()
            ->count(10)
            ->state(new Sequence(
                ['date' => '2024-05-20'],
                ['date' => '2025-05-20'],
            ))
            ->create();

        $result = $this->createUseCase(ano: 2024);

        $this->assertCount(5, $result->items);
    }

    public function testLstDividendsByIdAsset()
    {
        $this->createFakers();
        $uuid1 = Uuid::random();
        $uuid2 = Uuid::random();
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
        $uuid = Uuid::random();
        $type = DividendType::JCP;
        DividendPayment::factory()->create([
            'asset_id' => $uuid,
            'type' => $type,
            'date' => '2024-01-05',
        ]);

        $result = $this->createUseCase(ano: 2024, idAsset: 'uuid', idType: $type->value);
        $this->assertCount(0, $result->items);
        $result = $this->createUseCase(ano: 2024, idAsset: $uuid, idType: $type->value);
        $this->assertCount(1, $result->items);
    }
}
