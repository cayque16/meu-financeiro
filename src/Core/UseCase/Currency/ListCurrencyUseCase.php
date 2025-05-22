<?php

namespace Core\UseCase\Currency;

use Core\Domain\Repository\BaseRepositoryInterface;
use Core\UseCase\DTO\Currency\CurrencyInputDto;
use Core\UseCase\DTO\Currency\CurrencyOutputDto;
use Core\UseCase\Exceptions\NotFoundException;

class ListCurrencyUseCase
{
    public function __construct(
        protected BaseRepositoryInterface $repository
    ) { }

    public function execute(CurrencyInputDto $input): CurrencyOutputDto
    {
        $currency = $this->repository->findById($input->id);
        
        if($currency) {
            return new CurrencyOutputDto(
                id: $currency->id,
                name: $currency->name,
                symbol: $currency->symbol,
                isoCode: $currency->isoCode,
                split: $currency->split,
                decimals: $currency->decimals,
                description: $currency->description,
                isActive: $currency->isActive(),
                createdAt: $currency->createdAt(),
                updatedAt: $currency->updatedAt(),
                deletedAt: $currency->deletedAt(),
            );
        }
        throw new NotFoundException("No currency with that id was found: {$input->id}");
    }
}
