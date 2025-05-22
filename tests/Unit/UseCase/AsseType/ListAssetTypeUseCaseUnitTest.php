<?php

namespace Tests\Unit\UseCase\AsseType;

use Core\Domain\Entity\AssetType;
use Core\Domain\Repository\AssetTypeRepositoryInterface;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\Domain\ValueObject\Date;
use Core\UseCase\AssetType\ListAssetTypeUseCase;
use Core\UseCase\DTO\AssetType\AssetTypeInputDto;
use Core\UseCase\DTO\AssetType\AssetTypeOutputDto;
use Core\UseCase\Exceptions\NotFoundException;
use Mockery;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class ListAssetTypeUseCaseUnitTest extends TestCase
{
    public function testListSingle()
    {
        $uuid = (string) Uuid::uuid4();

        $mockEntity = $this->mockEntity($uuid);

        $mockRepository = $this->mockRepository($uuid, $mockEntity);

        $mockInputDto = $this->mockInputDto($uuid);

        $useCase = new ListAssetTypeUseCase($mockRepository);
        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(AssetTypeOutputDto::class, $response);
        $this->assertEquals($uuid, $response->id);
    }

    public function testListNotFound()
    {
        $uuid = (string) Uuid::uuid4();

        $mockRepository = $this->mockRepository($uuid, null);
        $mockInputDto = $this->mockInputDto($uuid);
        $useCase = new ListAssetTypeUseCase($mockRepository);

        $this->expectException(NotFoundException::class);
        $response = $useCase->execute($mockInputDto);
    }

    private function mockInputDto($uuid)
    {
        return Mockery::mock(AssetTypeInputDto::class, [$uuid]);
    }

    private function mockRepository($uuid, $mockEntity) 
    {
        $mockRepository = Mockery::mock(stdClass::class, AssetTypeRepositoryInterface::class);
        $mockRepository->shouldReceive('findById')
            ->once()
            ->with($uuid)
            ->andReturn($mockEntity);

        return $mockRepository;
    }

    private function mockEntity($uuid)
    {
        $mockEntity = Mockery::mock(AssetType::class, [
            'name',
            $uuid,
            'desc',
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
