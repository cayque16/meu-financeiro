<?php

namespace Tests\Unit\UseCase\Brokerage;

use Core\Domain\Repository\BrokerageRepositoryInterface;
use Core\UseCase\Brokerage\ActivateDisableBrokerageUseCase;
use Core\UseCase\DTO\Brokerage\ActivateDisable\ActivateDisableBrokerageInputDto;
use Core\UseCase\DTO\Brokerage\ActivateDisable\ActivateDisableBrokerageOutputDto;
use Tests\Unit\UseCase\AbstractActivateDisableUseCaseTest;

class ActivateDisableBrokerageUseCaseUnitTest extends AbstractActivateDisableUseCaseTest
{
    protected function getUseCase($mockRepo)
    {
        return new ActivateDisableBrokerageUseCase($mockRepo);
    }

    protected function getOutputDto()
    {
        return ActivateDisableBrokerageOutputDto::class;
    }

    protected function getRepositoryInterface()
    {
        return BrokerageRepositoryInterface::class;
    }

    protected function getInputDto()
    {
        return ActivateDisableBrokerageInputDto::class;
    }
}
