<?php

namespace Core\Domain\Entity;

use Core\Domain\Validation\Factories\AssetTypeValidatorFactory;
use Core\Domain\ValueObject\Uuid;
use DateTime;

class AssetType extends BaseEntity
{
    public function __construct(
        protected string $name,
        protected Uuid|string $id = '',
        protected string $description = '',
        protected DateTime|string $createdAt = '',
        protected ?DateTime $excludedAt = null,
    ) {
        parent::__construct($id, $createdAt, $excludedAt);
        
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
