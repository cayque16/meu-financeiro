<?php

namespace Core\UseCase\DTO\Brokerage\Create;

use Core\Domain\ValueObject\Cnpj;

class CreateBrokerageInputDto
{
    public function __construct(
        public string $name,
        public string $webPage,
        public Cnpj $cnpj,
    ) { }
}
