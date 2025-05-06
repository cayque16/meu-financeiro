<?php

namespace Core\UseCase\DTO\Currency\ListCurrencies;

class ListCurrenciesInputDto
{
    public function __construct(
        public string $filter = '',
        public string $order = 'DESC',
    ) { }    
}
