<?php

namespace Tests\Unit\UseCase\Currency;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Core\Domain\Entity\Currency as EntityCurrency;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\UseCase\Currency\ListCurrencyUseCase;
use Core\UseCase\DTO\Currency\CurrencyInputDto;
use Core\UseCase\DTO\Currency\CurrencyOutputDto;
use stdClass;
use Mockery;

class ListCurrencyUseCaseUnitTest extends TestCase
{
    public function testListSingle()
    {
        $uuid = (string) RamseyUuid::uuid4();

        $mockEntity = Mockery::mock(EntityCurrency::class, [
            $name = 'test name',
            $symbol = 'R$',
            $isoCode = 'BRL',
            $split = 100,
            $decimals = 2,
            $uuid,
            $description = 'test description'
        ]);
        $mockEntity ->shouldReceive("createdAt")->andReturn($createdAt = date('Y-m-d H:i:s'));
        $mockEntity ->shouldReceive("excludedAt")->andReturn($excludedAt = '');

        $mockRepository = Mockery::mock(stdClass::class, BaseRepositoryInterface::class);
        $mockRepository ->shouldReceive('findById')
            ->once()
            ->with($uuid)
            ->andReturn($mockEntity);

        $mockInputDto = Mockery::mock(CurrencyInputDto::class, [$uuid]);

        $useCase = new ListCurrencyUseCase($mockRepository);
        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(CurrencyOutputDto::class, $response);
        $this->assertEquals($uuid, $response->id);
        $this->assertEquals($name, $response->name);
        $this->assertEquals($symbol, $response->symbol);
        $this->assertEquals($isoCode, $response->isoCode);
        $this->assertEquals($split, $response->split);
        $this->assertEquals($decimals, $response->decimals);
        $this->assertEquals($description, $response->description);
        $this->assertEquals($createdAt, $response->createdAt);
        $this->assertEquals($excludedAt, $response->excludedAt);

        Mockery::close();
    }
}
