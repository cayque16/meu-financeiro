<?php

namespace Tests\Unit\UseCase\Currency;

use Core\Domain\Repository\BaseRepositoryInterface;
use Core\UseCase\Currency\ListCurrenciesUseCase;
use Core\UseCase\DTO\Currency\ListCurrencies\ListCurrenciesInputDto;
use Core\UseCase\DTO\Currency\ListCurrencies\ListCurrenciesOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ListCurrenciesUseCaseUnitTest extends TestCase
{
    public function testListAll()
    {
        $mockRepository = Mockery::mock(stdClass::class, BaseRepositoryInterface::class);
        $mockRepository->shouldReceive("findAll")->once()->andReturn([]);

        $useCase = new ListCurrenciesUseCase($mockRepository);

        $mockInputDto = Mockery::mock(ListCurrenciesInputDto::class, ['', 'DESC']);

        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(ListCurrenciesOutputDto::class, $response);
    }
}
