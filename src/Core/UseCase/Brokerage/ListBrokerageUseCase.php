<?php

namespace Core\UseCase\Brokerage;

use Core\Domain\Repository\BrokerageRepositoryInterface;
use Core\UseCase\DTO\Brokerage\BrokerageInputDto;
use Core\UseCase\DTO\Brokerage\BrokerageOutputDto;
use Core\UseCase\Exceptions\NotFoundException;

class ListBrokerageUseCase
{
    public function __construct(
        protected BrokerageRepositoryInterface $repository,
    ) { }

    public function execute(BrokerageInputDto $input): BrokerageOutputDto
    {
        $brokerage = $this->repository->findById($input->id);

        if ($brokerage) {
            return new BrokerageOutputDto(
                id: $brokerage->id,
                name: $brokerage->name,
                webPage: $brokerage->webPage,
                cnpj: $brokerage->cnpj,
                isActive: $brokerage->isActive(),
                createdAt: $brokerage->createdAt(),
                updatedAt: $brokerage->updatedAt(),
                deletedAt: $brokerage->deletedAt(),
            );
        }

        throw new NotFoundException("No brokerage with that id was found: {$input->id}");
    }
}
