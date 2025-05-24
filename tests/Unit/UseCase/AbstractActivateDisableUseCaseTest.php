<?php

namespace Tests\Unit\UseCase;

use Mockery;
use Tests\TestCase;
use Core\Domain\ValueObject\Uuid;
use stdClass;

abstract class AbstractActivateDisableUseCaseTest extends TestCase
{
    abstract protected function getUseCase($mockRepo);

    abstract protected function getInputDto();

    abstract protected function getOutputDto();

    abstract protected function getRepositoryInterface();

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

        $useCase = $this->getUseCase($mockRepo);
        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf($this->getOutputDto(), $response);
        $this->assertEquals($expected, $response->success);
    }

    protected function mockRepo($methodName, $return)
    {
        $mockRepo = Mockery::mock(stdClass::class, $this->getRepositoryInterface());
        $mockRepo->shouldReceive($methodName)->once()->andReturn($return);

        return $mockRepo;
    }

    protected function mockInputDto($uuid, $return)
    {
        return Mockery::mock($this->getInputDto(), [$uuid, $return]);
    }  

    protected function providerTest()
    {
        $uuid = Uuid::random();
        return [
            "activate success" => [$uuid, "activate", true, true, true],
            "disable success" => [$uuid, "disable", true, false, true],
            "activate failed" => [$uuid, "activate", false, true, false],
            "disable failed" => [$uuid, "disable", false, false, false],
        ];
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
