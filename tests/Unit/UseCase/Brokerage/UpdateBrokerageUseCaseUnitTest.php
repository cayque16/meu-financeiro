<?php

namespace Tests\Unit\UseCase\Brokerage;

use Core\Domain\Entity\Brokerage;
use Core\Domain\Repository\BrokerageRepositoryInterface;
use Core\Domain\ValueObject\Cnpj;
use Core\Domain\ValueObject\Date;
use Core\Domain\ValueObject\Uuid;
use Core\UseCase\Brokerage\UpdateBrokerageUseCase;
use Core\UseCase\DTO\Brokerage\Update\UpdateBrokerageInputDto;
use Core\UseCase\DTO\Brokerage\Update\UpdateBrokerageOutputDto;
use Core\UseCase\Exceptions\NotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class UpdateBrokerageUseCaseUnitTest extends TestCase
{
    public function testUpdate()
    {
        $uuid = $this->getUuid();

        $mockEntity = $this->mockEntity($uuid);

        $useCase = new UpdateBrokerageUseCase($this->mockRepository($uuid, $mockEntity));

        $response = $useCase->execute($this->mockInput($uuid));

        $this->assertInstanceOf(UpdateBrokerageOutputDto::class, $response);
    }

    public function testUpdateNotFound()
    {
        $uuid = $this->getUuid();

        $useCase = new UpdateBrokerageUseCase($this->mockRepository($uuid, null, times2: 0));

        $this->expectException(NotFoundException::class);
        $useCase->execute($this->mockInput($uuid));
    }

    private function getUuid()
    {
        return (string) Uuid::random();
    }

    private function mockInput($uuid)
    {
        $mockInput = Mockery::mock(
            UpdateBrokerageInputDto::class,
            [$uuid, "new name", "http://ow.tz/gej", Cnpj::random()]
        );

        return $mockInput;
    }

    private function mockRepository($uuid, $mockEntity, $times1 = 1, $times2 = 1)
    {
        $mockRepository = Mockery::mock(
            stdClass::class,
            BrokerageRepositoryInterface::class
        );
        $mockRepository->shouldReceive("findById")
            ->times($times1)
            ->with($uuid)
            ->andReturn($mockEntity);

        $mockRepository->shouldReceive("update")
            ->times($times2)
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
        $mockEntity->shouldReceive('update')->once();
        $mockEntity->shouldReceive('id')->once()->andReturn($uuid);
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
