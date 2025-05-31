<?php

namespace App\Repositories\Eloquent;

use App\Models\DividendPayment as DividendPaymentModel;
use Core\Domain\Entity\DividendPayment as DividendPaymentEntity;
use App\Models\Asset as AssetModel;
use App\Models\Currency as CurrencyModel;
use Core\Domain\Entity\BaseEntity;
use Core\Domain\Enum\DividendType;
use Core\Domain\Repository\DividendPaymentRepositoryInterface;
use Core\Domain\ValueObject\Date;
use Core\Domain\ValueObject\Uuid;
use Core\UseCase\Exceptions\NotImplementedException;

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
            "payment_date" => $entity->paymentDate,
            "fiscal_year" => $entity->fiscalYear,
            "type" => $entity->type->value,
            "amount" => $entity->amount,
            "currency_id" => $entity->currency->id(),
        ]);

        return $this->toBaseEntity($payment);
    }

    public function lstDividends(
        ?int $paymentYear = null,
        ?int $fiscalYear = null,
        ?string $idAsset = null,
        ?string $idType = null
    ): array {
        $query = $this->model->withTrashed();

        if ($paymentYear) {
            $query = $query->whereYear('payment_date', $paymentYear);
        }

        if ($fiscalYear) {
            $query = $query->where('fiscal_year', $fiscalYear);
        }

        if ($idAsset) {
            $query = $query->where('asset_id', $idAsset);
        }

        if ($idType) {
            $query = $query->where('type', $idType);
        }

        $result = $query->orderBy('payment_date', 'DESC')->get();
        
        return $result->map(fn ($model) => $this->toBaseEntity($model))->all();
    }

    public function findById(string $id): ?BaseEntity
    {
        if (!$entity = $this->model->withTrashed()->find($id)) {
            return null;
        }

        return $this->toBaseEntity($entity);
    }

    public function findAll(string $filter = '', string $orderBy = 'DESC', bool $includeInactive = true): array
    {
        $query = $includeInactive ? $this->model->withTrashed() : $this->model->newQuery();

        if ($filter) {
            $query->where('date', 'LIKE', "%{$filter}%");
        }

        $result = $query->orderBy('date', $orderBy)->get();

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

    public function lstYearsOfPayment(): array
    {
        $query = $this->model->withTrashed();

        $result = $query->select('payment_date')->groupBy('payment_date')->get();

        return $result->toArray();
    }

    public function lstFiscalYears(): array
    {
        $query = $this->model->withTrashed();

        $result = $query->select('fiscal_year')->groupBy('fiscal_year')->get();

        return $result->toArray();
    }

    public function toBaseEntity(object $data): BaseEntity
    {
        $asset = $this->repoAsset->toBaseEntity($data->asset);
        $currency = $this->repoCurrency->toBaseEntity($data->currency);
        
        $payment = new DividendPaymentEntity(
            id: new Uuid($data->id),
            asset: $asset,
            paymentDate: new Date($data->payment_date),
            fiscalYear: $data->fiscal_year,
            type: DividendType::from($data->type),
            amount: $data->amount,
            currency: $currency,
            createdAt: Date::fromNullable($data->created_at),
            updatedAt: Date::fromNullable($data->updated_at),
            deletedAt: Date::fromNullable($data->deleted_at),
        );

        return $payment;
    }
}
