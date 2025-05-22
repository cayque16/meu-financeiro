<?php

namespace App\Repositories\Eloquent;

use App\Models\Currency as CurrencyModel;
use Core\Domain\Entity\BaseEntity;
use Core\Domain\Entity\Currency as CurrencyEntity;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\Domain\ValueObject\Date;
use Core\Domain\ValueObject\Uuid;
use Core\UseCase\Exceptions\NotImplementedException;
use Illuminate\Database\Eloquent\Model;

class CurrencyEloquentRepository implements BaseRepositoryInterface
{
    public function __construct(
        protected CurrencyModel $model
    ) { }

    public function insert(BaseEntity $entity): BaseEntity
    {
        $currencyBd = $this->model->create([
            "id" => $entity->id,
            "name" => $entity->name,
            "symbol" => $entity->symbol,
            "iso_code" => $entity->isoCode,
            "split" => $entity->split,
            "decimals" => $entity->decimals,
            "description" => $entity->description,
        ]);

        return $this->toBaseEntity($currencyBd);
    }

    public function findByUuid(Uuid|string $uuid): ?Model
    {
        if (!$entity =  $this->model->where('id', $uuid)->first()) {
            return null;
        } 

        return $entity;
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
        $result = $this->model
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('name', 'LIKE', "%{$filter}%");
                }
            })
            ->orderBy('name', $orderBy)
            ->get();
        
        return $result->toArray();
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
        $currency = new CurrencyEntity(
            id: new Uuid($data->id),
            name: $data->name,
            symbol: $data->symbol,
            isoCode: $data->iso_code,
            split: $data->split,
            decimals: $data->decimals,
            description: $data->description,
            createdAt: Date::fromNullable($data->created_at),
            updatedAt: Date::fromNullable($data->updated_at),
            deletedAt: Date::fromNullable($data->deleted_at),
        );

        return $currency;
    }
}
