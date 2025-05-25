<?php

namespace Core\UseCase\DTO\DividendPayment\ListDividendsPayment;

class ListDividendsPaymentInputDto
{
    public function __construct(
        public ?int $paymentYear = null,
        public ?int $fiscalYear = null,
        public ?string $idAsset = null,
        public ?string $idType = null,
    ) { }
}
