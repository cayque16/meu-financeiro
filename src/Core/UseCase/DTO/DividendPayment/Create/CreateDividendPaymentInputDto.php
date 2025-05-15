<?php

namespace Core\UseCase\DTO\DividendPayment\Create;

use Core\Domain\Enum\DividendType;

class CreateDividendPaymentInputDto
{
    public function __construct(
        public string $idAsset,
        public string $date,
        public DividendType $type,
        public int $amount,
        public string $idCurrency,
    ) { }
}
