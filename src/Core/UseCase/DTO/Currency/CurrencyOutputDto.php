<?php

namespace Core\UseCase\DTO\Currency;

use Core\Domain\ValueObject\Date;

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
        public Date $createdAt,
        public Date|string $excludedAt = '',
    ) {}
}
