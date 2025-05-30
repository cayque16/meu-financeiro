<?php

namespace App\Repositories\Eloquent;

use App\Models\Asset as AssetModel;
use App\Models\AssetsType;
use Core\Domain\Entity\Asset as AssetEntity;
use Core\Domain\Entity\BaseEntity;
use Core\Domain\Repository\AssetRepositoryInterface;
use Core\Domain\ValueObject\Date;
use Core\UseCase\Exceptions\NotImplementedException;
use Core\Domain\ValueObject\Uuid;
use Illuminate\Database\Eloquent\Model;

class AssetEloquentRepository implements AssetRepositoryInterface
{
    protected AssetsTypeEloquentRepository $repoAssetsType;

    public function __construct(
        protected AssetModel $model
    ) { 
        $this->repoAssetsType = new AssetsTypeEloquentRepository(new AssetsType());
    }

    public function insert(BaseEntity $entity): BaseEntity
    {
        $assetBd = $this->model->create([
            "id" => $entity->id,
            "code" => $entity->code,
            "description" => $entity->description,
            "assets_type_id" => $entity->type->id,
        ]);

        return $this->toBaseEntity($assetBd);
    }

    public function findByUuid(Uuid|string $uuid): ?Model
    {
        if (!$entity =  $this->model->withTrashed()->where('id', $uuid)->first()) {
            return null;
        } 

        return $entity;
    }
    
    public function findById(string $id): ?BaseEntity
    {
        $entity = Uuid::isUuidValid($id) ? $this->findByUuid($id) : $this->model->find($id);
        if ($entity) {
            return $this->toBaseEntity($entity);
        }
        return null;
    }

    public function findAll(string $filter = '', string $orderBy = 'DESC', bool $includeInactive = true): array
    {
        $query = $includeInactive ? $this->model->withTrashed() : $this->model->newQuery();

        if ($filter) {
            $query->where('code', 'LIKE', "%{$filter}%");
        }

        $result = $query->orderBy('code', $orderBy)->get();

        return $result->map(fn ($model) => $this->toBaseEntity($model))->all();
    }

    public function update(BaseEntity $entity): ?BaseEntity
    {
        if (!$assetDb = $this->findByUuid($entity->id)) {
            return null;
        }

        $assetDb->update([
            'code' => $entity->code,
            'assets_type_id' => $entity->type->id,
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
        if (!$typeBd = $this->findByUuid($id)) {
            return null;
        }

        return $typeBd->restore();
    }

    public function disable(string $id): ?bool
    {
        if (!$typeBd = $this->findByUuid($id)) {
            return null;
        }

        return $typeBd->delete();
    }

    public function toBaseEntity(object $data): BaseEntity
    {
        $asset = new AssetEntity(
            id: $data->id,
            code: $data->code,
            type: $this->repoAssetsType->toBaseEntity($data->assetsType),
            description: $data->description,
            createdAt: Date::fromNullable($data->created_at),
            updatedAt: Date::fromNullable($data->updated_at),
            deletedAt: Date::fromNullable($data->deleted_at),
        );

        return $asset;
    }
}
