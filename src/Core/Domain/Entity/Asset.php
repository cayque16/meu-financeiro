<?php

namespace Core\Domain\Entity;

use Core\Domain\Validation\Factories\AssetValidatorFactory;
use Core\Domain\ValueObject\Uuid;
use DateTime;

class Asset extends BaseEntity
{
    public function __construct(
        protected string $code,
        protected AssetType $type,
        protected Uuid|string $id = '',
        protected string $description = '',
        protected DateTime|string $createdAt = '',
        protected ?DateTime $excludedAt = null,
    ) {
        parent::__construct($id, $createdAt, $excludedAt);

        $this->validator = AssetValidatorFactory::create();
        $this->validation();
    }

    public function update(
        string $code = null,
        AssetType $type = null,
        string $description = null
    ) {
        $this->code = $this->orSelfIfNull($code, $this->code);
        $this->type = $this->orSelfIfNull($type, $this->type);
        $this->description = $this->orSelfIfNull($description, $this->description);

        $this->validation();
    }
}
