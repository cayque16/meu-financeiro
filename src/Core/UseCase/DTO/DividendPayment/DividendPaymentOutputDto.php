<?php

namespace Core\UseCase\DTO\DividendPayment;

use Core\Domain\Enum\DividendType;
use Core\Domain\ValueObject\Date;

class DividendPaymentOutputDto
{
    public function __construct(
        public string $id,
        public string $idAsset,
        public Date $paymentDate,
        public int $fiscalYear,
        public DividendType $type,
        public int $amount,
        public string $idCurrency,
        public bool $isActive,
        public ?Date $createdAt = null,
        public ?Date $updatedAt = null,
        public ?Date $deletedAt = null,
    ) { }
}
