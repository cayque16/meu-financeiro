<?php

namespace Tests\Unit\UseCase\AsseType;

use Core\Domain\Entity\AssetType;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\UseCase\AssetType\UpdateAssetTypeUseCase;
use Core\UseCase\DTO\AssetType\Update\UpdateAssetTypeInputDto;
use Core\UseCase\DTO\AssetType\Update\UpdateAssetTypeOutputDto;
use Core\UseCase\Exceptions\NotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
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
        return (string) Uuid::uuid4()->toString();
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
            BaseRepositoryInterface::class
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
        // $mockEntity->shouldReceive('isActive')->once()->andReturn(true);
        // $mockEntity->shouldReceive('createdAt')->once()->andReturn(date('Y-m-d H:i:s'));

        return $mockEntity;
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
