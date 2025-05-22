<?php

namespace Tests\Unit\UseCase\Currency;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Core\Domain\Entity\Currency as EntityCurrency;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\Domain\ValueObject\Date;
use Core\UseCase\Currency\ListCurrencyUseCase;
use Core\UseCase\DTO\Currency\CurrencyInputDto;
use Core\UseCase\DTO\Currency\CurrencyOutputDto;
use Core\UseCase\Exceptions\NotFoundException;
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
        $mockEntity->shouldReceive("isActive")->once()->andReturn($isActive = true);
        $mockEntity->shouldReceive("createdAt")->once()->andReturn($createdAt = new Date());
        $mockEntity->shouldReceive("updatedAt")->once()->andReturn($updatedAt = null);
        $mockEntity->shouldReceive("deletedAt")->once()->andReturn($deletedAt = null);

        $mockRepository = $this->mockRepository($uuid, $mockEntity);

        $mockInputDto = $this->mockInputDto($uuid);

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
        $this->assertEquals($isActive, $response->isActive);
        $this->assertEquals($createdAt, $response->createdAt);
        $this->assertEquals($updatedAt, $response->updatedAt);
        $this->assertEquals($deletedAt, $response->deletedAt);
    }

    public function testSingleNotFound()
    {
        $uuid = (string) RamseyUuid::uuid4();
        $mockRepository = $this->mockRepository($uuid, null);
        $mockInputDto = $this->mockInputDto($uuid);

        $useCase = new ListCurrencyUseCase($mockRepository);
        $this->expectException(NotFoundException::class);
        $response = $useCase->execute($mockInputDto);
    }

    private function mockInputDto($uuid)
    {
        return Mockery::mock(CurrencyInputDto::class, [$uuid]);
    }

    private function mockRepository($uuid, $mockEntity)
    {
        $mockRepository = Mockery::mock(stdClass::class, BaseRepositoryInterface::class);
        $mockRepository ->shouldReceive('findById')
            ->once()
            ->with($uuid)
            ->andReturn($mockEntity);

        return $mockRepository;
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
