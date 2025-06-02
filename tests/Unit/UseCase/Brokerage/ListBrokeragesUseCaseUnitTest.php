<?php

namespace Tests\Unit\UseCase\Brokerage;

use Core\Domain\Repository\BrokerageRepositoryInterface;
use Core\UseCase\Brokerage\ListBrokeragesUseCase;
use Core\UseCase\DTO\Brokerage\ListBrokerages\ListBrokeragesInputDto;
use Core\UseCase\DTO\Brokerage\ListBrokerages\ListBrokeragesOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ListBrokeragesUseCaseUnitTest extends TestCase
{
    public function testListAll()
    {
        $mockRepository = Mockery::mock(stdClass::class, BrokerageRepositoryInterface::class);
        $mockRepository->shouldReceive("findAll")->once()->andReturn([]);

        $useCase = new ListBrokeragesUseCase($mockRepository);

        $mockInputDto = Mockery::mock(ListBrokeragesInputDto::class, ['', 'DESC', true]);

        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(ListBrokeragesOutputDto::class, $response);

        Mockery::close();
    }
}
