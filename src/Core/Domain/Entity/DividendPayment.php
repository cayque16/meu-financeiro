<?php

namespace Core\Domain\Entity;

use Core\Domain\Enum\DividendType;
use Core\Domain\Validation\Factories\DividendPaymentValidatorFactory;
use Core\Domain\ValueObject\Uuid;
use DateTime;

class DividendPayment extends BaseEntity
{
    public function __construct(
        protected Asset $asset,
        protected DateTime $date,
        protected DividendType $type,
        protected int $amount,
        protected Currency $currency,
        protected Uuid|string $id = '',
        protected DateTime|string $createdAt = '',
        protected ?DateTime $excludedAt = null,
    ) {
        parent::__construct($id, $createdAt, $excludedAt);

        $this->validator = DividendPaymentValidatorFactory::create();
        $this->validation();
    }

    public function date(): string
    {
        return $this->date->format('Y-m-d H:i:s');
    }
}
