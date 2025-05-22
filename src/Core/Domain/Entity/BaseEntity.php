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
        protected ?Date $createdAt = null,
        protected ?Date $deletedAt = null,
        protected ?Date $updatedAt = null,
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

    public function createdAt(): ?Date
    {
        return $this->createdAt ?? null;
    }

    public function updatedAt(): ?Date
    {
        return $this->updatedAt ?? null;
    }

    public function deletedAt(): ?Date
    {
        return $this->deletedAt ?? null;
    }

    public function isActive(): bool
    {
        return is_null($this->deletedAt);
    }

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
