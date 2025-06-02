<?php

namespace Tests\Unit\UseCase\Brokerage;

use Core\Domain\Entity\Brokerage;
use Core\Domain\Repository\BrokerageRepositoryInterface;
use Core\Domain\ValueObject\Cnpj;
use Core\Domain\ValueObject\Date;
use Core\Domain\ValueObject\Uuid;
use Core\UseCase\Brokerage\ListBrokerageUseCase;
use Core\UseCase\DTO\Brokerage\BrokerageInputDto;
use Core\UseCase\DTO\Brokerage\BrokerageOutputDto;
use Core\UseCase\Exceptions\NotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ListBrokerageUseCaseUnitTest extends TestCase
{
    public function testListSingle()
    {
        $uuid = (string) Uuid::random();

        $mockEntity = $this->mockEntity($uuid);

        $mockRepository = $this->mockRepository($uuid, $mockEntity);

        $mockInputDto = $this->mockInputDto($uuid);

        $useCase = new ListBrokerageUseCase($mockRepository);
        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(BrokerageOutputDto::class, $response);
        $this->assertEquals($uuid, $response->id);
    }

    public function testListNotFound()
    {
        $uuid = (string) Uuid::random();

        $mockRepository = $this->mockRepository($uuid, null);
        $mockInputDto = $this->mockInputDto($uuid);
        $useCase = new ListBrokerageUseCase($mockRepository);

        $this->expectException(NotFoundException::class);
        $useCase->execute($mockInputDto);
    }

    private function mockInputDto($uuid)
    {
        return Mockery::mock(BrokerageInputDto::class, [$uuid]);
    }

    private function mockRepository($uuid, $mockEntity)
    {
        $mockRepository = Mockery::mock(stdClass::class, BrokerageRepositoryInterface::class);
        $mockRepository->shouldReceive('findById')
            ->once()
            ->with($uuid)
            ->andReturn($mockEntity);

        return $mockRepository;
    }

    private function mockEntity($uuid)
    {
        $mockEntity = Mockery::mock(Brokerage::class, [
            'name',
            'http://idcoj.nf/mo',
            Cnpj::random(),
            $uuid,
        ]);
        $mockEntity->shouldReceive("isActive")->andReturn(true);
        $mockEntity->shouldReceive("createdAt")->once()->andReturn(new Date());
        $mockEntity->shouldReceive('updatedAt')->once()->andReturn(null);
        $mockEntity->shouldReceive('deletedAt')->once()->andReturn(null);

        return $mockEntity;
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
