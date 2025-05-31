<?php

namespace Tests\Unit\UseCase\Asset;

use Core\Domain\Entity\Asset;
use Core\Domain\Entity\AssetType;
use Core\Domain\Enum\DividendType;
use Core\Domain\Repository\AssetRepositoryInterface;
use Core\Domain\Repository\AssetTypeRepositoryInterface;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\Domain\ValueObject\Date;
use Core\UseCase\Asset\CreateAssetUseCase;
use Core\UseCase\DTO\Asset\Create\CreateAssetInputDto;
use Core\UseCase\DTO\Asset\Create\CreateAssetOutputDto;
use Core\UseCase\Exceptions\NotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;
use Core\Domain\ValueObject\Uuid;
use stdClass;

class CreateAssetUseCaseUnitTest extends TestCase
{
    public function testCreate()
    {
        $uuidAsset = (string) Uuid::random();
        $uuidType = (string) Uuid::random();
        
        $mockType = Mockery::mock(AssetType::class);
        $mockType->shouldReceive('id')->andReturn($uuidType);

        $mockEntity = Mockery::mock(Asset::class, ['BTC', $mockType, $uuidAsset, 'desc']);
        $mockEntity->shouldReceive('id')->andReturn($uuidAsset);
        $mockEntity->shouldReceive('isActive')->andReturn(true);
        $mockEntity->shouldReceive('createdAt')->once()->andReturn(new Date());
        $mockEntity->shouldReceive('updatedAt')->once()->andReturn(null);
        $mockEntity->shouldReceive('deletedAt')->once()->andReturn(null);

        $mockRepoAsset = $this->mockRepo("insert", $mockEntity, interface: AssetRepositoryInterface::class);

        $mockRepoAssetType = $this->mockRepo("findById", $mockType, interface: AssetTypeRepositoryInterface::class);

        $useCase = new CreateAssetUseCase($mockRepoAsset, $mockRepoAssetType);

        $mockInput = $this->mockInput($uuidType);

        $response = $useCase->execute($mockInput);

        $this->assertInstanceOf(CreateAssetOutputDto::class, $response);        
    }

    public function testCreateNotFoundAssetType()
    {
        $mockRepoAsset = $this->mockRepo("insert", null, 0, interface: AssetRepositoryInterface::class);

        $mockRepoAssetType = $this->mockRepo("findById", null, interface: AssetTypeRepositoryInterface::class);

        $useCase = new CreateAssetUseCase($mockRepoAsset, $mockRepoAssetType);

        $this->expectException(NotFoundException::class);
        $useCase->execute($this->mockInput(""));
    }

    private function mockInput($uuid)
    {
        $mockInput = Mockery::mock(
            CreateAssetInputDto::class,
            ['BTC', $uuid, 'desc']
        );

        return $mockInput;
    }

    private function mockRepo($name, $return, $times = 1, $interface = AssetRepositoryInterface::class)
    {
        $mockRepo = Mockery::mock(stdClass::class, $interface);
        $mockRepo->shouldReceive($name)
            ->times($times)
            ->andReturn($return);

        return $mockRepo;
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
