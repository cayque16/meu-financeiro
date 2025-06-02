<?php

namespace Core\UseCase\DTO\Brokerage\ListBrokerages;

class ListBrokeragesOutputDto
{
    public function __construct(
        public array $items
    ) { }
}
