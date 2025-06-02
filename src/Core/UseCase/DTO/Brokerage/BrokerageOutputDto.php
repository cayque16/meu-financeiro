<?php

namespace Core\UseCase\DTO\Brokerage;

use Core\Domain\ValueObject\Cnpj;
use Core\Domain\ValueObject\Date;

class BrokerageOutputDto
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
