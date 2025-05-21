<?php

namespace Core\Domain\Entity;

use Core\Domain\Validation\Factories\AssetTypeValidatorFactory;
use Core\Domain\ValueObject\Date;
use Core\Domain\ValueObject\Uuid;

class AssetType extends BaseEntity
{
    public function __construct(
        protected string $name,
        protected Uuid|string $id = '',
        protected string $description = '',
        protected Date|string $createdAt = '',
        protected Date|string $deletedAt = '',
        protected Date|string $updatedAt = '',
        protected ?int $oldId = 0,
    ) {
        parent::__construct($id, $createdAt, $deletedAt);
        
        $this->validator = AssetTypeValidatorFactory::create();
        $this->validation();
    }

    public function update(string $name = null, string $description = null)
    {
        $this->name = $name ?? $this->name;
        $this->description = $description ?? $this->description;
        
        $this->validation();
    }
}
