<?php

namespace Core\UseCase\DTO\DividendPayment;

class DividendPaymentOutputDto
{
    public function __construct(
        public string $id,
        public string $idAsset,
        public string $date,
        public int $paymentType,
        public int $amount,
        public string $idCurrency,
        public bool $isActive,
        public string $createdAt,
    ) { }
}
