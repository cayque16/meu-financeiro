<?php

namespace Core\Domain\Entity;

use DateTime;
use Exception;

abstract class BaseEntity
{
    protected DateTime|string $createdAt = '';
    
    protected ?DateTime $excludedAt = null;

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

    public function createdAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }

    public function excludedAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
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
    }
}
