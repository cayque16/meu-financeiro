<?php

namespace App\Repositories\Eloquent;

use Core\Domain\Repository\BaseRepositoryInterface;
use App\Models\Asset as AssetModel;
use App\Models\AssetsType;
use Core\Domain\Entity\Asset as AssetEntity;
use Core\Domain\Entity\BaseEntity;
use Core\UseCase\Exceptions\NotImplementedException;

class AssetEloquentRepository implements BaseRepositoryInterface
{
    protected AssetsTypeEloquentRepository $repoAssetsType;

    public function __construct(
        protected AssetModel $model
    ) { 
        $this->repoAssetsType = new AssetsTypeEloquentRepository(new AssetsType());
    }

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
        $asset = new AssetEntity(
            id: $data->uuid,
            code: $data->codigo,
            type: $this->repoAssetsType->toBaseEntity($data->assetsType),
            description: $data->descricao,
            createdAt: $data->created_at,
        );

        return $asset;
    }
}
