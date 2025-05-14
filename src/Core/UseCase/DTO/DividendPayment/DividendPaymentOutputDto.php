<?php

namespace Core\UseCase\DTO\DividendPayment;

use Core\Domain\Enum\PaymentType;

class DividendPaymentOutputDto
{
    public function __construct(
        public string $id,
        public string $idAsset,
        public string $date,
        public PaymentType $type,
        public int $amount,
        public string $idCurrency,
        public bool $isActive,
        public string $createdAt,
    ) { }
}
