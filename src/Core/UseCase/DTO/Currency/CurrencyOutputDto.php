<?php

namespace Core\UseCase\DTO\Currency;

class CurrencyOutputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string $symbol,
        public string $isoCode,
        public int $split,
        public int $decimals,
        public string $description,
        public string $createdAt,
        public  $excludedAt,
    ) {}
}
