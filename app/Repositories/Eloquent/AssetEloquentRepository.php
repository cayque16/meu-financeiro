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
            "uuid" => $entity->id,
            "codigo" => $entity->code,
            "descricao" => $entity->description,
            "id_assets_type" => $entity->type->oldId,
            "uuid_assets_type" => $entity->type->id,
        ]);

        return $this->toBaseEntity($assetBd);
    }

    public function findByUuid(Uuid|string $uuid): ?Model
    {
        if (!$entity =  $this->model->where('uuid', $uuid)->first()) {
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

    public function findAll(string $filter = '', $orderBy = 'DESC'): array
    {
        $result = $this->model
            ->withTrashed()
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('codigo', 'LIKE', "%{$filter}%");
                }
            })
            ->orderBy('codigo', $orderBy)
            ->get();
        
        $return = [];
        foreach ($result->all() as $model) {
            $return[] = $this->toBaseEntity($model);
        }
        return $return;
    }

    public function update(BaseEntity $entity): ?BaseEntity
    {
        if (!$assetDb = $this->findByUuid($entity->id)) {
            return null;
        }

        $assetDb->update([
            'codigo' => $entity->code,
            'id_assets_type' => $entity->type->oldId,
            'uuid_assets_type'=> $entity->type->id,
            'descricao'=> $entity->description,
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
            id: $data->uuid,
            code: $data->codigo,
            type: $this->repoAssetsType->toBaseEntity($data->assetsType),
            description: $data->descricao,
            createdAt: Date::fromNullable($data->created_at),
            updatedAt: Date::fromNullable($data->updated_at),
            deletedAt: Date::fromNullable($data->deleted_at),
        );

        return $asset;
    }
}
