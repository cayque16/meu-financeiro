<?php

namespace Core\UseCase\DTO\DividendPayment\Create;

use Core\Domain\Enum\PaymentType;

class CreateDividendPaymentInputDto
{
    public function __construct(
        public string $idAsset,
        public string $date,
        public PaymentType $type,
        public int $amount,
        public string $idCurrency,
    ) { }
}
