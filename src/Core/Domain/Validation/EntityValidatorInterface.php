<?php

namespace Core\Domain\Validation;

use Core\Domain\Entity\BaseEntity;

interface EntityValidatorInterface
{
    public function validate(BaseEntity $baseEntity): bool;
    public function failed(): bool;
    public function errors(): array;
}
