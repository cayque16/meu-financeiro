<?php

namespace Tests\Unit\UseCase\DividendPayment;

use Core\Domain\Repository\DividendPaymentRepositoryInterface;
use Core\UseCase\DividendPayment\ListYearsOfPaymentUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ListYearsOfPaymentUseCaseUnitTest extends TestCase
{
    public function testListEmpty()
    {
        $useCase = new ListYearsOfPaymentUseCase($this->mockRepository());
        $response = $useCase->execute();

        $this->assertEmpty($response);
    }

    public function testResultingArray()
    {
        $array = [
            ['payment_date' => '1994-04-15'],
            ['payment_date' => '2015-01-19'],
            ['payment_date' => '2016-02-25'],
            ['payment_date' => '2018-06-15'],
        ];
        
        $useCase = new ListYearsOfPaymentUseCase($this->mockRepository($array));
        $response = $useCase->execute();

        $this->assertEquals([
            '1994' => '1994',
            '2015' => '2015',
            '2016' => '2016',
            '2018' => '2018',
        ], $response);
    }

    private function mockRepository($return = [])
    {
        $mockRepository = Mockery::mock(stdClass::class, DividendPaymentRepositoryInterface::class);
        $mockRepository->shouldReceive("lstYearsOfPayment")
            ->once()   
            ->andReturn($return);

        return $mockRepository;
    }
}
