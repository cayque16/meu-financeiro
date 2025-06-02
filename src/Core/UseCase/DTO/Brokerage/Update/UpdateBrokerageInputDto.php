<?php

namespace Core\UseCase\DTO\Brokerage\Update;

use Core\Domain\ValueObject\Cnpj;

class UpdateBrokerageInputDto
{
    public function __construct(
        public string $id,
        public ?string $name = null,
        public ?string $webPage = null,
        public ?Cnpj $cnpj = null,
    ) { }
}
