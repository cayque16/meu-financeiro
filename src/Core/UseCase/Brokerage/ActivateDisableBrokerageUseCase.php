<?php

namespace Core\UseCase\Brokerage;

use Core\Domain\Repository\BrokerageRepositoryInterface;
use Core\UseCase\DTO\Brokerage\ActivateDisable\ActivateDisableBrokerageInputDto;
use Core\UseCase\DTO\Brokerage\ActivateDisable\ActivateDisableBrokerageOutputDto;

class ActivateDisableBrokerageUseCase
{
    public function __construct(
        private BrokerageRepositoryInterface $repository,
    ) { }

    public function execute(ActivateDisableBrokerageInputDto $input): ActivateDisableBrokerageOutputDto
    {
        $result = $input->activate ?
            $this->repository->activate($input->id)
            : $this->repository->disable($input->id);

        return new ActivateDisableBrokerageOutputDto(success: $result);
    }
}
