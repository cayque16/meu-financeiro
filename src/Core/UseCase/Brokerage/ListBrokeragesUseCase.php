<?php

namespace Core\UseCase\Brokerage;

use Core\Domain\Repository\BrokerageRepositoryInterface;
use Core\UseCase\DTO\Brokerage\ListBrokerages\ListBrokeragesInputDto;
use Core\UseCase\DTO\Brokerage\ListBrokerages\ListBrokeragesOutputDto;

class ListBrokeragesUseCase
{
    public function __construct(
        protected BrokerageRepositoryInterface $repository,
    ) { }

    public function execute(ListBrokeragesInputDto $input): ListBrokeragesOutputDto
    {
        $brokerages = $this->repository->findAll(
            filter: $input->filter,
            orderBy: $input->order,
            includeInactive: $input->includeInactive,
        );

        return new ListBrokeragesOutputDto($brokerages);
    }
}
