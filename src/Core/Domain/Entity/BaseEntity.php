<?php

namespace Core\Domain\Entity;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\EntityValidatorInterface;
use Core\Domain\ValueObject\Date;
use Core\Domain\ValueObject\Uuid;
use Exception;

class BaseEntity
{
    protected EntityValidatorInterface $validator;

    protected function __construct(
        protected Uuid|string $id = '',
        protected Date|string $createdAt = '',
        protected Date|string $deletedAt = '',
        protected Date|string $updatedAt = '',
    ) {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::random();
        $this->createdAt = $this->createdAt ? new Date($this->createdAt) : new Date();
    }

    public function __get($property)
    {
        if (isset($this->{$property})) {
            return $this->{$property};
        }

        $className = get_class($this);
        throw new Exception("Property {$property} not found in {$className}");
    }

    public function id(): string
    {
        return (string) $this->id;
    }

    /*public function createdAt(): Date|string
    {
        return $this->createdAt;
    }

    public function deletedAt(): Date|string
    {
        return $this->excludedAt;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getExcludedAt(): ?DateTime
    {
        return $this->excludedAt;
    }

    public function activate(): void
    {
        $this->excludedAt = null;
    }

    public function disable(): void
    {
        $this->excludedAt = new DateTime();
    }

    public function isActive(): bool
    {
        return empty($this->excludedAt);
    }*/

    protected function validation()
    {
        if (!$this->validator) {
            throw new EntityValidationException('The child class must define its validation interface.');
        }
        
        $this->validator->validate($this);
        if($this->validator->failed()) {
            throw new EntityValidationException(json_encode($this->validator->errors()));
        }
    }
}
