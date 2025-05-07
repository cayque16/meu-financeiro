<?php

namespace Tests\Unit\UseCase\AsseType;

use Core\Domain\Entity\AssetType;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\UseCase\AssetType\CreateAssetTypeUseCase;
use Core\UseCase\DTO\AssetType\Create\CreateAssetTypeInputDto;
use Core\UseCase\DTO\AssetType\Create\CreateAssetTypeOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class CreateAssetTypeUseCaseUnitTest extends TestCase
{
    public function testCreate()
    {
        $uuid = (string) Uuid::uuid4();
        $mockEntity = Mockery::mock(AssetType::class, ['name', $uuid, 'desc']);
        $mockEntity->shouldReceive('id')->andReturn($uuid);
        $mockEntity->shouldReceive('isActive')->andReturn(true);
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-a H:i:s'));
        

        $mockRepository = Mockery::mock(stdClass::class, BaseRepositoryInterface::class);
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
