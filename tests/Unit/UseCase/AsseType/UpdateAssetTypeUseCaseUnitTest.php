<?php

namespace Tests\Unit\UseCase\AsseType;

use Core\Domain\Entity\AssetType;
use Core\Domain\Repository\AssetTypeRepositoryInterface;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\Domain\ValueObject\Date;
use Core\UseCase\AssetType\UpdateAssetTypeUseCase;
use Core\UseCase\DTO\AssetType\Update\UpdateAssetTypeInputDto;
use Core\UseCase\DTO\AssetType\Update\UpdateAssetTypeOutputDto;
use Core\UseCase\Exceptions\NotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;
use Core\Domain\ValueObject\Uuid;
use stdClass;

class UpdateAssetTypeUseCaseUnitTest extends TestCase
{
    public function testUpdate()
    {
        $uuid = $this->getUuid();
        
        $mockEntity = $this->mockEntity($uuid);

        $useCase = new UpdateAssetTypeUseCase($this->mockRepository($uuid, $mockEntity));

        $response = $useCase->execute($this->mockInput($uuid));

        $this->assertInstanceOf(UpdateAssetTypeOutputDto::class, $response);
    }

    private function getUuid()
    {
        return (string) Uuid::random();
    }

    public function testUpdateNotFound()
    {
        $uuid = $this->getUuid();

        $useCase = new UpdateAssetTypeUseCase(
            $this->mockRepository($uuid, null, times2: 0)
        );

        $this->expectException(NotFoundException::class);
        $response = $useCase->execute($this->mockInput($uuid));
    }

    private function mockInput($uuid)
    {
        $mockInput = Mockery::mock(
            UpdateAssetTypeInputDto::class,
            [$uuid, "new name", "new desc"]
        );

        return $mockInput;
    }

    private function mockRepository($uuid, $mockEntity, $times1 = 1, $times2 = 1)
    {
        $mockRepository = Mockery::mock(
            stdClass::class,
            AssetTypeRepositoryInterface::class
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

    private function mockEntity(string $uuid)
    {
        $mockEntity = Mockery::mock(AssetType::class, ['name', $uuid, 'desc']);
        $mockEntity->shouldReceive('update')->once();
        $mockEntity->shouldReceive('id')->once()->andReturn($uuid);
        $mockEntity->shouldReceive('isActive')->once()->andReturn(true);
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
