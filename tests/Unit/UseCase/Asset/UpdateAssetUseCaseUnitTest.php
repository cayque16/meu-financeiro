<?php

namespace Tests\Unit\UseCase\Asset;

use Core\Domain\Entity\Asset;
use Core\Domain\Entity\AssetType;
use Core\Domain\Repository\AssetRepositoryInterface;
use Core\Domain\Repository\AssetTypeRepositoryInterface;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\Domain\ValueObject\Date;
use Core\UseCase\Asset\UpdateAssetUseCase;
use Core\UseCase\DTO\Asset\Update\UpdateAssetInputDto;
use Core\UseCase\DTO\Asset\Update\UpdateAssetOutputDto;
use Core\UseCase\Exceptions\NotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class UpdateAssetUseCaseUnitTest extends TestCase
{
    public function testUpdate()
    {
        $uuid = $this->getUuid();
        $uuidType = $this->getUuid();
        
        $mockEntity = $this->mockEntity($uuid, $uuidType, times1: 1, times2: 0);

        $mockRepoAssetType = $this->mockRepo("findById", $this->mockType($uuidType), interface: AssetTypeRepositoryInterface::class);

        $mockRepoAsset = $this->mockRepo(
            "update",
            $this->mockEntity($uuid, $uuidType, 'BTC', times1: 0)
        );
        $mockRepoAsset->shouldReceive("findById")
            ->once()
            ->andReturn($mockEntity);

        $useCase = new UpdateAssetUseCase($mockRepoAsset, $mockRepoAssetType);

        $response = $useCase->execute($this->mockInput($uuid));

        $this->assertInstanceOf(UpdateAssetOutputDto::class, $response);
        $this->assertEquals($uuid, $response->id);
        $this->assertEquals('BTC', $response->code);
        $this->assertEquals('desc', $response->description);
        $this->assertEquals($uuidType, $response->idType);
    }

    public function testUpdateNotFoundAsset()
    {
        $mockRepoAsset = $this->mockRepo("findById", null);
        $mockEntity = $this->mockEntity(
            uuid: $this->getUuid(),
            uuidType: $this->getUuid(),
            times1: 0,
            times2: 0
        );
        $mockRepoAssetType = $this->mockRepo("findById", $mockEntity, 0, interface: AssetTypeRepositoryInterface::class);

        $useCase = new UpdateAssetUseCase($mockRepoAsset, $mockRepoAssetType);

        $this->expectException(NotFoundException::class);
        $response = $useCase->execute($this->mockInput($this->getUuid()));
    }

    public function testUpdateNotFoundAssetType()
    {
        $mockRepoAsset = $this->mockRepo(
            "findById",
            $this->mockEntity($this->getUuid(), $this->getUuid(), times1: 0, times2: 0)
        );
        $mockRepoAssetType = $this->mockRepo("findById", null, interface: AssetTypeRepositoryInterface::class);
        $useCase = new UpdateAssetUseCase($mockRepoAsset, $mockRepoAssetType);

        $this->expectException(NotFoundException::class);
        $response = $useCase->execute($this->mockInput($this->getUuid()));
    }

    private function getUuid()
    {
        return (string) Uuid::uuid4();
    }

    private function mockInput($uuid)
    {
        $mockInput = Mockery::mock(
            UpdateAssetInputDto::class,
            [$uuid, "BTC", $this->getUuid(), 'desc']
        );

        return $mockInput;
    }

    private function mockRepo($name, $return, $times = 1, $interface = AssetRepositoryInterface::class)
    {
        $mockRepository = Mockery::mock(
            stdClass::class,
            $interface
        );
        $mockRepository->shouldReceive($name)
            ->times($times)
            ->andReturn($return);

        return $mockRepository;
    }

    private function mockEntity(
        $uuid,
        $uuidType,
        $code = 'CODE',
        $desc = 'desc',
        $times1 = 1,
        $times2 = 1
    ) {
        $mockEntity = Mockery::mock(Asset::class, [$code, $this->mockType($uuidType), $uuid, $desc]);
        $mockEntity->shouldReceive('update')->times($times1);
        $mockEntity->shouldReceive('id')->times($times2)->andReturn($uuid);
        $mockEntity->shouldReceive('isActive')->times($times2)->andReturn(true);
        $mockEntity->shouldReceive('createdAt')->times($times2)->andReturn(new Date());
        $mockEntity->shouldReceive('updatedAt')->times($times2)->andReturn(null);
        $mockEntity->shouldReceive('deletedAt')->times($times2)->andReturn(null);

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
