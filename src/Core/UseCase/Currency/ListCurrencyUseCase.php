<?php

namespace Core\UseCase\Currency;

use Core\Domain\Repository\BaseRepositoryInterface;
use Core\UseCase\DTO\Currency\CurrencyInputDto;
use Core\UseCase\DTO\Currency\CurrencyOutputDto;

class ListCurrencyUseCase
{
    public function __construct(
        protected BaseRepositoryInterface $repository
    ) { }

    public function execute(CurrencyInputDto $input): CurrencyOutputDto
    {
        $currency = $this->repository->findById($input->id);

        return new CurrencyOutputDto(
            id: $currency->id,
            name: $currency->name,
            symbol: $currency->symbol,
            isoCode: $currency->isoCode,
            split: $currency->split,
            decimals: $currency->decimals,
            description: $currency->description,
            createdAt: $currency->createdAt(),
            excludedAt: $currency->excludedAt()
        );
    }
}
