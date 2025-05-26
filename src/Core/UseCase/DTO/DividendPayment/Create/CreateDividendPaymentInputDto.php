<?php

namespace Core\UseCase\DTO\DividendPayment\Create;

use Core\Domain\Enum\DividendType;
use Core\Domain\ValueObject\Date;

class CreateDividendPaymentInputDto
{
    public function __construct(
        public string $idAsset,
        public Date $paymentDate,
        public int $fiscalYear,
        public DividendType $type,
        public float $amount,
        public string $idCurrency,
    ) { }
}
