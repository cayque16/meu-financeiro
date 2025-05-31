<?php

namespace App\Repositories\Eloquent;

use App\Models\AssetsType as AssetsTypeModel;
use Core\Domain\Entity\AssetType as AssetTypeEntity;
use Core\Domain\Entity\BaseEntity;
use Core\Domain\Repository\AssetTypeRepositoryInterface;
use Core\Domain\ValueObject\Date;
use Core\UseCase\Exceptions\NotImplementedException;

class AssetsTypeEloquentRepository implements AssetTypeRepositoryInterface
{
    public function __construct(
        protected AssetsTypeModel $model
    ) { }

    public function insert(BaseEntity $entity): BaseEntity
    {
        $typeBd = $this->model->create([
            "id" => $entity->id,
            "name" => $entity->name,
            "description" => $entity->description,
        ]);

        return $this->toBaseEntity($typeBd);
    }
    
    public function findById(string $id): ?BaseEntity
    {
        $entity = $this->model->withTrashed()->find($id);
        if ($entity) {
            return $this->toBaseEntity($entity);
        }
        return null;
    }

    public function findAll(string $filter = '', string $orderBy = 'DESC', bool $includeInactive = true): array
    {
        $query = $includeInactive ? $this->model->withTrashed() : $this->model->newQuery();

        if ($filter) {
            $query->where('name', 'LIKE', "%{$filter}%");
        }

        $result = $query->orderBy('name', $orderBy)->get();

        return $result->map(fn ($model) => $this->toBaseEntity($model))->all();
    }

    public function update(BaseEntity $entity): ?BaseEntity
    {
         if (!$assetDb = $this->model->withTrashed()->find($entity->id)) {
            return null;
        }

        $assetDb->update([
            'name' => $entity->name,
            'description' => $entity->description,
        ]);

        return $this->toBaseEntity($assetDb);
    }

    public function delete(BaseEntity $entity): bool
    {
        throw new NotImplementedException('This method has not been implemented!');
    }

    public function activate(string $id): ?bool
    {
        if (!$typeBd = $this->model->withTrashed()->find($id)) {
            return null;
        }

        return $typeBd->restore();
    }

    public function disable(string $id): ?bool
    {
        if (!$typeBd = $this->model->withTrashed()->find($id)) {
            return null;
        }

        return $typeBd->delete();
    }

    public function toBaseEntity(object $data): BaseEntity
    {
        $type = new AssetTypeEntity(
            id: $data->id,
            name: $data->name,
            description: $data->description,
            createdAt: Date::fromNullable($data->created_at),
            updatedAt: Date::fromNullable($data->updated_at),
            deletedAt: Date::fromNullable($data->deleted_at),
        );
        
        return $type;
    }
}
