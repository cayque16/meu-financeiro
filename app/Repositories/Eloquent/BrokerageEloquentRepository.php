<?php

namespace App\Repositories\Eloquent;

use Core\Domain\Entity\BaseEntity;
use Core\Domain\Repository\BrokerageRepositoryInterface;
use Core\UseCase\Exceptions\NotImplementedException;
use App\Models\Brokerage as BrokerageModel;
use Core\Domain\Entity\Brokerage as BrokerageEntity;
use Core\Domain\ValueObject\Cnpj;
use Core\Domain\ValueObject\Date;

class BrokerageEloquentRepository implements BrokerageRepositoryInterface
{
    public function __construct(
        protected BrokerageModel $model
    ) { }

    public function insert(BaseEntity $entity): BaseEntity
    {
        $brokerageDb = $this->model->create([
            "id" => $entity->id,
            "name" => $entity->name,
            "web_page" => $entity->webPage,
            "cnpj" => $entity->cnpj,
        ]);

        return $this->toBaseEntity($brokerageDb);
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
        if(!$brokerageDb = $this->model->withTrashed()->find($entity->id)) {
            return null;
        }

        $brokerageDb->update([
            'name' => $entity->name,
            'web_page' => $entity->webPage,
            'cnpj' => (string) $entity->cnpj
        ]);

        return $this->toBaseEntity($brokerageDb);
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
        $brokerage = new BrokerageEntity(
            id: $data->id,
            name: $data->name,
            webPage: $data->web_page,
            cnpj: new Cnpj($data->cnpj),
            createdAt: Date::fromNullable($data->created_at),
            updatedAt: Date::fromNullable($data->updated_at),
            deletedAt: Date::fromNullable($data->deleted_at),
        );

        return $brokerage;
    }
}
