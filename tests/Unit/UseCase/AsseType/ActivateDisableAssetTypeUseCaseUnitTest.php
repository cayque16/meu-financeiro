<?php

namespace Tests\Unit\UseCase\AsseType;

use Core\Domain\Repository\AssetTypeRepositoryInterface;
use Core\Domain\ValueObject\Uuid;
use Core\UseCase\AssetType\ActivateDisableAssetTypeUseCase;
use Core\UseCase\DTO\AssetType\ActivateDisable\ActivateDisableAssetTypeInputDto;
use Core\UseCase\DTO\AssetType\ActivateDisable\ActivateDisableAssetTypeOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ActivateDisableAssetTypeUseCaseUnitTest extends TestCase
{
    /**
     * @dataProvider providerTest
     */
    public function testActivateDisable(
        $typeId,
        $method,
        $returnRepo,
        $returnInput,
        $expected
    ) {
        $mockRepo = $this->mockRepo($method, $returnRepo);

        $mockInputDto = $this->mockInputDto($typeId, $returnInput);

        $useCase = new ActivateDisableAssetTypeUseCase($mockRepo);
        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(ActivateDisableAssetTypeOutputDto::class, $response);
        $this->assertEquals($expected, $response->success);
    }

    protected function providerTest()
    {
        $typeId = Uuid::random();
        return [
            "activate success" => [$typeId, "activate", true, true, true],
            "disable success" => [$typeId, "disable", true, false, true],
            "activate failed" => [$typeId, "activate", false, true, false],
            "disable failed" => [$typeId, "disable", false, false, false],
        ];
    }

    private function mockRepo($methodName, $return)
    {
        $mockRepo = Mockery::mock(stdClass::class, AssetTypeRepositoryInterface::class);
        $mockRepo->shouldReceive($methodName)->once()->andReturn($return);

        return $mockRepo;
    }

    private function mockInputDto($uuid, $return)
    {
        return Mockery::mock(ActivateDisableAssetTypeInputDto::class, [$uuid, $return]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
