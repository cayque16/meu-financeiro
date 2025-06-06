<?php

namespace Tests\Unit\UseCase\Asset;

use Core\Domain\Entity\Asset;
use Core\Domain\Entity\AssetType;
use Core\Domain\Repository\AssetRepositoryInterface;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\Domain\ValueObject\Date;
use Core\UseCase\Asset\ListAssetUseCase;
use Core\UseCase\DTO\Asset\AssetInputDto;
use Core\UseCase\DTO\Asset\AssetOutputDto;
use Core\UseCase\Exceptions\NotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;
use Core\Domain\ValueObject\Uuid;
use stdClass;

class ListAssetUseCaseUnitTest extends TestCase
{
    public function testListSingle()
    {
        $uuid = (string) Uuid::random();
        $uuidType = (string) Uuid::random();

        $mockEntity = $this->mockEntity($uuid, $uuidType);
        $mockRepository = $this->mockRepository($uuid, $mockEntity);
        $mockInputDto = $this->mockInputDto($uuid);

        $useCase = new ListAssetUseCase($mockRepository);
        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(AssetOutputDto::class, $response);
        $this->assertEquals($uuid, $response->id);
        $this->assertEquals('BTC', $response->code);
        $this->assertEquals('desc', $response->description);
        $this->assertEquals($uuidType, $response->typeId);
    }

    public function testListNotFound()
    {
        $uuid = (string) Uuid::random();

        $mockRepository = $this->mockRepository($uuid, null);
        $mockInputDto = $this->mockInputDto($uuid);
        $useCase = new ListAssetUseCase($mockRepository);

        $this->expectException(NotFoundException::class);
        $response = $useCase->execute($mockInputDto);
    }

    private function mockInputDto($uuid)
    {
        return Mockery::mock(AssetInputDto::class, [$uuid]);
    }

    private function mockRepository($uuid, $mockEntity)
    {
        $mockRepository = Mockery::mock(stdClass::class, AssetRepositoryInterface::class);
        $mockRepository->shouldReceive("findById")
            ->once()   
            ->with($uuid)
            ->andReturn($mockEntity);

        return $mockRepository;
    }

    private function mockEntity($uuid, $uuidType)
    {
        $mockEntity = Mockery::mock(Asset::class, [
            'BTC',
            $this->mockType($uuidType),
            $uuid,
            'desc'
        ]);
        $mockEntity->shouldReceive('id')->once()->andReturn($uuid);
        $mockEntity->shouldReceive('isActive')->once()->andReturn(true);
        $mockEntity->shouldReceive('createdAt')->once()->andReturn(new Date());
        $mockEntity->shouldReceive('updatedAt')->once()->andReturn(null);
        $mockEntity->shouldReceive('deletedAt')->once()->andReturn(null);

        return $mockEntity;
    }

    private function mockType($uuid)
    {
        $mockType = Mockery::mock(AssetType::class);
        $mockType->shouldReceive('id')->andReturn($uuid);

        return $mockType;
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
