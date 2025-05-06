<?php

namespace Core\UseCase\Currency;

use Core\Domain\Repository\BaseRepositoryInterface;
use Core\UseCase\DTO\Currency\ListCurrencies\ListCurrenciesInputDto;
use Core\UseCase\DTO\Currency\ListCurrencies\ListCurrenciesOutputDto;

class ListCurrenciesUseCase
{
    public function __construct(
        protected BaseRepositoryInterface $repository
    ) { }

    public function execute(ListCurrenciesInputDto $input): ListCurrenciesOutputDto
    {
        $result = $this->repository->findAll(
            filter: $input->filter,
            orderBy: $input->order
        );

        return new ListCurrenciesOutputDto(items: $result);
    }
}
