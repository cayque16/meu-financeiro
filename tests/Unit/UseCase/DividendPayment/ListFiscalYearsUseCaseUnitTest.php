<?php

namespace Tests\Unit\UseCase\DividendPayment;

use Core\Domain\Repository\DividendPaymentRepositoryInterface;
use Core\UseCase\DividendPayment\ListFiscalYearsUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ListFiscalYearsUseCaseUnitTest extends TestCase
{
    public function testListEmpty()
    {
        $useCase = new ListFiscalYearsUseCase($this->mockRepository());
        $response = $useCase->execute();

        $this->assertEmpty($response);
    }

    public function testResultingArray()
    {
        $array = [
            ['fiscal_year' => '1994'],
            ['fiscal_year' => '2015'],
            ['fiscal_year' => '2016'],
            ['fiscal_year' => '2018'],
        ];
        
        $useCase = new ListFiscalYearsUseCase($this->mockRepository($array));
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
        $mockRepository->shouldReceive("lstFiscalYears")
            ->once()   
            ->andReturn($return);

        return $mockRepository;
    }
}
