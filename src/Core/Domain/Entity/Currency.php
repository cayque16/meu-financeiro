<?php

namespace Core\Domain\Entity;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Factory\CurrencyValidatorFactory;
use Core\Domain\ValueObject\Uuid;
use DateTime;

class Currency extends BaseEntity
{
    public function __construct(
        protected string $name,
        protected string $symbol,
        protected string $isoCode,
        protected int $split,
        protected Uuid|string $id = '',
        protected string $description = '',
        protected DateTime|string $createdAt = '',
        protected DateTime|null $excludedAt = null,
    ) {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::random();
        $this->isoCode = strtoupper($isoCode);
        $this->createdAt = $this->createdAt ? new DateTime($this->createdAt) : new DateTime();

        $this->validation();
    }

    protected function validation()
    {
        $errors = CurrencyValidatorFactory::create()->validate($this);
        if ($errors) {
            throw new EntityValidationException(implode("\n", $errors));
        }
    }
}
