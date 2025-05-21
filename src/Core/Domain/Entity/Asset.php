<?php

namespace Core\Domain\Entity;

use Core\Domain\Validation\Factories\AssetValidatorFactory;
use Core\Domain\ValueObject\Date;
use Core\Domain\ValueObject\Uuid;

class Asset extends BaseEntity
{
    public function __construct(
        protected string $code,
        protected AssetType $type,
        protected Uuid|string $id = '',
        protected string $description = '',
        protected Date|string $createdAt = '',
        protected Date|string $deletedAt = '',
        protected Date|string $updatedAt = '',
    ) {
        parent::__construct($id, $createdAt, $deletedAt);

        $this->validator = AssetValidatorFactory::create();
        $this->validation();
    }

    public function update(
        string $code = null,
        AssetType $type = null,
        string $description = null
    ) {
        $this->code = $code ?? $this->code;
        $this->type = $type ?? $this->type;
        $this->description = $description ?? $this->description;

        $this->validation();
    }
}
