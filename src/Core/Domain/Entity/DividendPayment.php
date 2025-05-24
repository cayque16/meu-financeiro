<?php

namespace Core\Domain\Entity;

use Core\Domain\Enum\DividendType;
use Core\Domain\Validation\Factories\DividendPaymentValidatorFactory;
use Core\Domain\ValueObject\Date;
use Core\Domain\ValueObject\Uuid;

class DividendPayment extends BaseEntity
{
    public function __construct(
        protected Asset $asset,
        protected Date $date,
        protected DividendType $type,
        protected int $amount,
        protected Currency $currency,
        protected Uuid|string $id = '',
        protected ?Date $createdAt = null,
        protected ?Date $deletedAt = null,
        protected ?Date $updatedAt = null,
    ) {
        parent::__construct($id, $createdAt, $deletedAt, $updatedAt);
        
        $this->validator = DividendPaymentValidatorFactory::create();
        $this->validation();
    }

    public function getAmountFormatted(): string
    {
        return $this->currency->printFormatted($this->amount);
    }
}
