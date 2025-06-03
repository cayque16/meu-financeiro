<?php

namespace Tests\Feature\Core\UseCase\DividendPayment;

use App\Models\DividendPayment;
use App\Repositories\Facades\DividendPaymentRepositoryFacade;
use Core\UseCase\DividendPayment\ListYearsOfPaymentUseCase;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class ListYearsOfPaymentUseCaseTest extends TestCase
{
    use DividendPaymentFakersTrait;

    private function createUseCase()
    {
        $repository = DividendPaymentRepositoryFacade::createRepository();
        $useCase = new ListYearsOfPaymentUseCase($repository);

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
        DividendPayment::factory()
            ->count(30)
            ->state(new Sequence(
                ['payment_date' => '1994-04-15'],
                ['payment_date' => '1996-06-15'],
                ['payment_date' => '2015-01-10'],
                ['payment_date' => '2018-04-13'],
            ))
            ->create();

        $response = $this->createUseCase();
        $this->assertEquals([
            '1994' => '1994',
            '1996' => '1996',
            '2015' => '2015',
            '2018' => '2018',
        ], $response);
    }
}
