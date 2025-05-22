<?php

namespace Core\Domain\Entity;

use Core\Domain\Validation\Factories\CurrencyValidatorFactory;
use Core\Domain\ValueObject\Date;
use Core\Domain\ValueObject\Uuid;

class Currency extends BaseEntity
{
    public function __construct(
        protected string $name,
        protected string $symbol,
        protected string $isoCode,
        protected int $split,
        protected int $decimals = 2,
        protected Uuid|string $id = '',
        protected string $description = '',
        protected ?Date $createdAt = null,
        protected ?Date $deletedAt = null,
        protected ?Date $updatedAt = null,
    ) {
        parent::__construct($id, $createdAt, $deletedAt);
        $this->isoCode = strtoupper($isoCode);

        $this->validator = CurrencyValidatorFactory::create();
        $this->validation();
    }

    public function printFormatted(int $value): string
    {
        $value /= $this->split;

        return $this->symbol.' '. number_format($value,  $this->decimals, ',', '.');
    }
}
