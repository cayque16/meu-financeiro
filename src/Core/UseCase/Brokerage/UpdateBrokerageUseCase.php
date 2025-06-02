<?php

namespace Core\UseCase\Brokerage;

use Core\Domain\Repository\BrokerageRepositoryInterface;
use Core\UseCase\DTO\Brokerage\Update\UpdateBrokerageInputDto;
use Core\UseCase\DTO\Brokerage\Update\UpdateBrokerageOutputDto;
use Core\UseCase\Exceptions\NotFoundException;

class UpdateBrokerageUseCase
{
    public function __construct(
        protected BrokerageRepositoryInterface $repository,
    ) { }

    public function execute(UpdateBrokerageInputDto $input): UpdateBrokerageOutputDto
    {
        $brokerage = $this->repository->findById($input->id);

        if ($brokerage) {
            $brokerage->update($input->name, $input->webPage, $input->cnpj);
            $return = $this->repository->update($brokerage);

            return new UpdateBrokerageOutputDto(
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

        throw new NotFoundException("No brokerage with that id was found: {$input->id}");
    }
}
