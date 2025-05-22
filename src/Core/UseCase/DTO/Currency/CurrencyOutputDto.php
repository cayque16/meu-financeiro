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
        public bool $isActive,
        public ?Date $createdAt = null,
        public ?Date $updatedAt = null,
        public ?Date $deletedAt = null,
    ) {}
}
