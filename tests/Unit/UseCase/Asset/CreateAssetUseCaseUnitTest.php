<?php

namespace Tests\Unit\UseCase\Asset;

use Core\Domain\Entity\Asset;
use Core\Domain\Entity\AssetType;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\UseCase\Asset\CreateAssetUseCase;
use Core\UseCase\DTO\Asset\CreateAssetInputDto;
use Core\UseCase\DTO\Asset\CreateAssetOutputDto;
use Core\UseCase\Exceptions\NotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class CreateAssetUseCaseUnitTest extends TestCase
{
    public function testCreate()
    {
        $uuidAsset = (string) Uuid::uuid4();
        $uuidType = (string) Uuid::uuid4();
        
        $mockType = Mockery::mock(AssetType::class);
        $mockType->shouldReceive('id')->andReturn($uuidType);

        $mockEntity = Mockery::mock(Asset::class, ['BTC', $mockType, $uuidAsset, 'desc']);
        $mockEntity->shouldReceive('id')->andReturn($uuidAsset);
        $mockEntity->shouldReceive('isActive')->andReturn(true);
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-a H:i:s'));

        $mockRepoAsset = $this->mockRepo("insert", $mockEntity);

        $mockRepoAssetType = $this->mockRepo("findById", $mockType);

        $useCase = new CreateAssetUseCase($mockRepoAsset, $mockRepoAssetType);

        $mockInput = $this->mockInput($uuidType);

        $response = $useCase->execute($mockInput);

        $this->assertInstanceOf(CreateAssetOutputDto::class, $response);        
    }

    public function testCreateNotFoundAssetType()
    {
        $mockRepoAsset = $this->mockRepo("insert", null, 0);

        $mockRepoAssetType = $this->mockRepo("findById", null);

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

    private function mockRepo($name, $return, $times = 1)
    {
        $mockRepo = Mockery::mock(stdClass::class, BaseRepositoryInterface::class);
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
