<?php

namespace App\Repositories\Eloquent;

use Core\Domain\Repository\BaseRepositoryInterface;
use App\Models\AssetsType as AssetsTypeModel;
use Core\Domain\Entity\AssetType as AssetTypeEntity;
use Core\Domain\Entity\BaseEntity;
use Core\UseCase\Exceptions\NotImplementedException;

class AssetsTypeEloquentRepository implements BaseRepositoryInterface
{
    public function __construct(
        protected AssetsTypeModel $model
    ) { }

    public function insert(BaseEntity $entity): BaseEntity
    {
        throw new NotImplementedException('This method has not been implemented!');
    }
    
    public function findById(string $id): ?BaseEntity
    {
        if (!$entity = $this->model->find($id)) {
            return null;
        }
        
        return $this->toBaseEntity($entity);
    }

    public function findAll(string $filter = '', $orderBy = 'DESC'): array
    {
        throw new NotImplementedException('This method has not been implemented!');
    }

    public function update(BaseEntity $entity): BaseEntity
    {
        throw new NotImplementedException('This method has not been implemented!');
    }

    public function delete(BaseEntity $entity): bool
    {
        throw new NotImplementedException('This method has not been implemented!');
    }

    public function toBaseEntity(object $data): BaseEntity
    {
        $type = new AssetTypeEntity(
            id: $data->uuid,
            name: $data->nome,
            description: $data->descricao,
            createdAt: $data->created_at,
        );

        return $type;
    }
}
