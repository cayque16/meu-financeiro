<?php

namespace Tests\Feature\Core\UseCase\DividendPayment;

use App\Models\DividendPayment;
use App\Repositories\Eloquent\DividendPaymentEloquentRepository;
use Core\UseCase\DividendPayment\ListFiscalYearsUseCase;
use Doctrine\DBAL\Schema\Sequence;
use Tests\TestCase;

class ListFiscalYearsUseCaseTest extends TestCase
{
    use DividendPaymentFakersTrait;

    private function createUseCase()
    {
        $repository = new DividendPaymentEloquentRepository(new DividendPayment());
        $useCase = new ListFiscalYearsUseCase($repository);

        return $useCase->execute();
    }

    public function testListEmpty()
    {
        $response = $this->createUseCase();
        $this->assertEmpty($response);
    }

    public function testResultingArray()
    {
        $this->createFakers();
        DividendPayment::factory()->create(['fiscal_year' => 1994]);
        DividendPayment::factory()->create(['fiscal_year' => 1996]);
        DividendPayment::factory()->create(['fiscal_year' => 2015]);
        DividendPayment::factory()->create(['fiscal_year' => 2018]);

        $response = $this->createUseCase();
        $this->assertEquals([
            '1994' => '1994',
            '1996' => '1996',
            '2015' => '2015',
            '2018' => '2018',
        ], $response);
    }
}
