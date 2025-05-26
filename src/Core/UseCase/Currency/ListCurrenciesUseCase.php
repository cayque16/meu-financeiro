<?php

namespace Core\UseCase\Currency;

use Core\Domain\Repository\CurrencyRepositoryInterface;
use Core\UseCase\DTO\Currency\ListCurrencies\ListCurrenciesInputDto;
use Core\UseCase\DTO\Currency\ListCurrencies\ListCurrenciesOutputDto;

class ListCurrenciesUseCase
{
    public function __construct(
        protected CurrencyRepositoryInterface $repository
    ) { }

    public function execute(ListCurrenciesInputDto $input): ListCurrenciesOutputDto
    {
        $result = $this->repository->findAll(
            filter: $input->filter,
            orderBy: $input->order,
            includeInactive: $input->includeInactive,
        );

        return new ListCurrenciesOutputDto(items: $result);
    }
}
