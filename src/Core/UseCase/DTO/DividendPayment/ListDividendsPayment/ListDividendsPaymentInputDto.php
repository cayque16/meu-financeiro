<?php

namespace Core\UseCase\DTO\DividendPayment\ListDividendsPayment;

class ListDividendsPaymentInputDto
{
    public function __construct(
        public ?int $ano = null,
        public ?string $idAsset = null,
        public ?int $idType = null,
    ) { }
}
