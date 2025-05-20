<?php

namespace App\Repositories\Eloquent;

use Core\Domain\Repository\BaseRepositoryInterface;
use App\Models\AssetsType as AssetsTypeModel;
use Core\Domain\Entity\AssetType as AssetTypeEntity;
use Core\Domain\Entity\BaseEntity;
use Core\Domain\Repository\AssetTypeRepositoryInterface;
use Core\UseCase\Exceptions\NotImplementedException;
use Core\Domain\ValueObject\Uuid;
use Illuminate\Database\Eloquent\Model;

class AssetsTypeEloquentRepository implements AssetTypeRepositoryInterface
{
    public function __construct(
        protected AssetsTypeModel $model
    ) { }

    public function insert(BaseEntity $entity): BaseEntity
    {
        $typeBd = $this->model->create([
            "uuid" => $entity->id,
            "nome"=> $entity->name,
            "descricao" => $entity->description,
        ]);

        return $this->toBaseEntity($typeBd);
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
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('nome', 'LIKE', "%{$filter}%");
                }
            })
            ->orderBy('nome', $orderBy)
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
            'nome' => $entity->name,
            'descricao' => $entity->description,
        ]);

        return $this->toBaseEntity($assetDb);
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
            oldId: $data->id,
        );

        return $type;
    }
}
