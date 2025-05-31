<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\BaseEntity;

interface BaseRepositoryInterface
{
    public function insert(BaseEntity $entity): BaseEntity;
    
    public function findById(string $id): ?BaseEntity;

    public function findAll(string $filter = '', string $orderBy = 'DESC', bool $includeInactive = true): array;

    public function update(BaseEntity $entity): ?BaseEntity;

    public function delete(BaseEntity $entity): bool;

    public function activate(string $id): ?bool;

    public function disable(string $id): ?bool;

    public function toBaseEntity(object $data): BaseEntity;
}
