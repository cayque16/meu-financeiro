<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\BaseEntity;

interface BaseRepositoryInterface
{
    public function insert(BaseEntity $entity): BaseEntity;
    
    public function findById(string $id): ?BaseEntity;

    public function findAll(string $filter = '', $orderBy = 'DESC'): array;

    public function update(BaseEntity $entity): BaseEntity;

    public function delete(BaseEntity $entity): bool;

    public function toBaseEntity(object $data): BaseEntity;
}
