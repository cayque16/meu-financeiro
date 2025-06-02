<?php

namespace Core\UseCase\DTO\Brokerage\Update;

use Core\Domain\ValueObject\Cnpj;
use Core\Domain\ValueObject\Date;

class UpdateBrokerageOutputDto
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
