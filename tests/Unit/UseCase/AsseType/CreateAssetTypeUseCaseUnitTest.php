<?php

namespace Tests\Unit\UseCase\AsseType;

use Core\Domain\Entity\AssetType;
use Core\Domain\Repository\AssetTypeRepositoryInterface;
use Core\Domain\ValueObject\Date;
use Core\UseCase\AssetType\CreateAssetTypeUseCase;
use Core\UseCase\DTO\AssetType\Create\CreateAssetTypeInputDto;
use Core\UseCase\DTO\AssetType\Create\CreateAssetTypeOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Core\Domain\ValueObject\Uuid;
use stdClass;

class CreateAssetTypeUseCaseUnitTest extends TestCase
{
    public function testCreate()
    {
        $uuid = (string) Uuid::random();
        $mockEntity = Mockery::mock(AssetType::class, ['name', $uuid, 'desc']);
        $mockEntity->shouldReceive('id')->andReturn($uuid);
        $mockEntity->shouldReceive('isActive')->andReturn(true);
        $mockEntity->shouldReceive('createdAt')->once()->andReturn(new Date());
        $mockEntity->shouldReceive('updatedAt')->once()->andReturn(null);
        $mockEntity->shouldReceive('deletedAt')->once()->andReturn(null);

        $mockRepository = Mockery::mock(stdClass::class, AssetTypeRepositoryInterface::class);
        $mockRepository->shouldReceive("insert")
            ->once()
            ->andReturn($mockEntity);
        
        $useCase = new CreateAssetTypeUseCase($mockRepository);

        $mockInput = Mockery::mock(CreateAssetTypeInputDto::class, ['name', 'desc']);
        $response = $useCase->execute($mockInput);

        $this->assertInstanceOf(CreateAssetTypeOutputDto::class, $response);

        Mockery::close();
    }
}
