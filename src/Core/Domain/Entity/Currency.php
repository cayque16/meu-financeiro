<?php

namespace Core\Domain\Entity;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\Factories\CurrencyValidatorFactory;
use Core\Domain\ValueObject\Uuid;
use DateTime;

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
        protected bool $isActive = true,
        protected DateTime|string $createdAt = '',
        protected ?DateTime $excludedAt = null,
    ) {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::random();
        $this->isoCode = strtoupper($isoCode);
        $this->createdAt = $this->createdAt ? new DateTime($this->createdAt) : new DateTime();

        $this->validation();
    }

    public function activate(): void
    {
        $this->isActive = true;
    }

    public function disable(): void
    {
        $this->isActive = false;
    }

    protected function validation()
    {
        $validator = CurrencyValidatorFactory::create();

        $validator->validate($this);
        if($validator->failed()) {
            throw new EntityValidationException(json_encode($validator->errors()));
        }
    }

    public function printFormatted(int $value): string
    {
        $value /= $this->split;

        return $this->symbol.' '. number_format($value,  $this->decimals, ',', '.');
    }
}
