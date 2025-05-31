<?php

namespace Tests\Unit\UseCase\DividendPayment;

use Core\Domain\Enum\DividendType;
use Core\Domain\Repository\DividendPaymentRepositoryInterface;
use Core\UseCase\DividendPayment\ListDividendsPaymentUseCase;
use Core\UseCase\DTO\DividendPayment\ListDividendsPayment\ListDividendsPaymentInputDto;
use Core\UseCase\DTO\DividendPayment\ListDividendsPayment\ListDividendsPaymentOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Core\Domain\ValueObject\Uuid;
use stdClass;

class ListDividendsPaymentUseCaseUnitTest extends TestCase
{
    public function testListDividends()
    {
        $mockRepository = Mockery::mock(stdClass::class, DividendPaymentRepositoryInterface::class);
        $mockRepository->shouldReceive("lstDividends")->once()->andReturn([]);

        $useCase = new ListDividendsPaymentUseCase($mockRepository);

        $idAsset = $this->getUuid();
        
        $mockInputDto = Mockery::mock(
            ListDividendsPaymentInputDto::class,
            [2025, 2024, $idAsset, DividendType::DIVIDENDS->value]
        );

        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(ListDividendsPaymentOutputDto::class, $response);

        Mockery::close();
    }

    private function getUuid()
    {
        return (string) Uuid::random();
    }
}
