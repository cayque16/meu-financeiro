<?php

namespace Core\UseCase\Brokerage;

use Core\Domain\Entity\Brokerage;
use Core\Domain\Repository\BrokerageRepositoryInterface;
use Core\UseCase\DTO\Brokerage\Create\CreateBrokerageInputDto;
use Core\UseCase\DTO\Brokerage\Create\CreateBrokerageOutputDto;

class CreateBrokerageUseCase 
{
    public function __construct(
        protected BrokerageRepositoryInterface $repository, 
    ) { }

    public function execute(CreateBrokerageInputDto $input): CreateBrokerageOutputDto
    {
        $brokerage = new Brokerage(
            name: $input->name,
            webPage: $input->webPage,
            cnpj: $input->cnpj,
        );

        $return = $this->repository->insert($brokerage);

        return new CreateBrokerageOutputDto(
            id: $return->id(),
            name: $return->name,
            webPage: $return->webPage,
            cnpj: $return->cnpj,
            isActive: $return->isActive(),
            createdAt: $return->createdAt(),
            updatedAt: $return->updatedAt(),
            deletedAt: $return->deletedAt(),
        );
    }
}
