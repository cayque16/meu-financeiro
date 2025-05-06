<?php

namespace Core\UseCase\DTO\Currency\ListCurrencies;

class ListCurrenciesOutputDto
{
    public function __construct(
        public array $items,    
    ) { }
}
