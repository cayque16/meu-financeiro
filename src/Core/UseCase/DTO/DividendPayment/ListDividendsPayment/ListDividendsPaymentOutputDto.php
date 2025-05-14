<?php

namespace Core\UseCase\DTO\DividendPayment\ListDividendsPayment;

class ListDividendsPaymentOutputDto
{
    public function __construct(
        public array $items
    ) { }
}
