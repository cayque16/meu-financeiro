<?php

namespace Core\UseCase\DTO\Brokerage\Create;

use Core\Domain\ValueObject\Cnpj;
use Core\Domain\ValueObject\Date;

class CreateBrokerageOutputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string $webPage,
        public Cnpj $cnpj,
        public bool $isActive,
        public ?Date $createdAt = null,
        public ?Date $updatedAt = null,
        public ?Date $deletedAt = null,
    ) { }
}
