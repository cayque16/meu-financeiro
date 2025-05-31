<?php

namespace Core\Domain\Entity;

use Core\Domain\Validation\Factories\BrokerageValidatorFactory;
use Core\Domain\ValueObject\Cnpj;
use Core\Domain\ValueObject\Date;
use Core\Domain\ValueObject\Uuid;

class Brokerage extends BaseEntity
{
    public function __construct(
        protected string $name,
        protected string $webPage,
        protected Cnpj $cnpj,
        protected Uuid|string $id = '',
        protected ?Date $createdAt = null,
        protected ?Date $deletedAt = null,
        protected ?Date $updatedAt = null,
    ) {
        parent::__construct($id, $createdAt, $deletedAt, $updatedAt);

        $this->validator = BrokerageValidatorFactory::create();
        $this->validation();
    }

    public function update(
        string $name = null,
        string $webPage = null,
        Cnpj $cnpj = null,
    ) {
        $this->name = $name ?? $this->name;
        $this->webPage = $webPage ?? $this->webPage;
        $this->cnpj = $cnpj ?? $this->cnpj;

        $this->validation();
    }
}
