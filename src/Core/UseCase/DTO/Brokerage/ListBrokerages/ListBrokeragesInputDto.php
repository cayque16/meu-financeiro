<?php

namespace Core\UseCase\DTO\Brokerage\ListBrokerages;

class ListBrokeragesInputDto
{
    public function __construct(
        public string $filter = '',
        public string $order = 'DESC',
        public bool $includeInactive = true,
    ) { }
}
