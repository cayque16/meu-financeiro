<?php

namespace App\Repositories\Eloquent;

use App\Models\DividendPayment as DividendPaymentModel;
use Core\Domain\Entity\DividendPayment as DividendPaymentEntity;
use App\Models\Asset as AssetModel;
use App\Models\Currency as CurrencyModel;
use Core\Domain\Entity\BaseEntity;
use Core\Domain\Enum\DividendType;
use Core\Domain\Repository\DividendPaymentRepositoryInterface;
use Core\Domain\ValueObject\Uuid;
use Core\UseCase\Exceptions\NotImplementedException;
use Illuminate\Database\Eloquent\Model;

class DividendPaymentEloquentRepository implements DividendPaymentRepositoryInterface
{
    protected AssetEloquentRepository $repoAsset;
    protected CurrencyEloquentRepository $repoCurrency;

    public function __construct(
        protected DividendPaymentModel $model
    ) { 
        $this->repoAsset = new AssetEloquentRepository(new AssetModel());
        $this->repoCurrency = new CurrencyEloquentRepository(new CurrencyModel());
    }

    public function insert(BaseEntity $entity): BaseEntity
    {
        $payment = $this->model->create([
            "id" => $entity->id,
            "asset_id" => $entity->asset->id(),
            "date" => $entity->date,
            "type" => $entity->type->value,
            "amount" => $entity->amount,
            "currency_id" => $entity->currency->id(),
        ]);

        return $this->toBaseEntity($payment);
    }

    public function lstDividends(
        ?int $ano = null,
        ?string $idAsset = null,
        ?string $idType = null
    ): array {
        $query = $this->model;

        if ($ano) {
            $query = $query->whereYear('date', $ano);
        }

        if ($idAsset) {
            $query = $query->where('asset_id', $idAsset);
        }

        if ($idType) {
            $query = $query->where('type', $idType);
        }

        return $query->orderBy('date', 'DESC')->get()->toArray();
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
                    $query->where('date', 'LIKE', "%{$filter}%");
                }
            })
            ->orderBy('date', $orderBy)
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
        $asset = $this->repoAsset->toBaseEntity($data->asset);
        $currency = $this->repoCurrency->toBaseEntity($data->currency);
        
        $payment = new DividendPaymentEntity(
            id: new Uuid($data->id),
            asset: $asset,
            date: $data->date,
            type: DividendType::from($data->type),
            amount: $data->amount,
            currency: $currency,
            createdAt: $data->created_at,
        );

        return $payment;
    }
}
