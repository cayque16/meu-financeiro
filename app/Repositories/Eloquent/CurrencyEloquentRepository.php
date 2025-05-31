<?php

namespace App\Repositories\Eloquent;

use App\Models\Currency as CurrencyModel;
use Core\Domain\Entity\BaseEntity;
use Core\Domain\Entity\Currency as CurrencyEntity;
use Core\Domain\Repository\CurrencyRepositoryInterface;
use Core\Domain\ValueObject\Date;
use Core\Domain\ValueObject\Uuid;
use Core\UseCase\Exceptions\NotImplementedException;

class CurrencyEloquentRepository implements CurrencyRepositoryInterface
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

    public function findById(string $id): ?BaseEntity
    {
        if (!$entity = $this->model->find($id)) {
            return null;
        }

        return $this->toBaseEntity($entity);
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

    public function update(BaseEntity $entity): BaseEntity
    {
        throw new NotImplementedException('This method has not been implemented!');
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
