<?php

namespace Tests\Unit\App\Models;

use App\Models\DividendPayment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DividendPaymentUnitTest extends ModelTestCase
{
    protected function model(): Model
    {
        return new DividendPayment();
    }

    protected function traits(): array
    {
        return [
            HasFactory::class,
            SoftDeletes::class,
        ];
    }
    
    protected function fillable(): array
    {
        return [
            'id',
            'asset_id',
            'payment_date',
            'fiscal_year',
            'type',
            'amount',
            'currency_id',
            'deleted_at',
            'created_at',
            'updated_at',
        ];
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'asset_id' => 'string',
            'currency_id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
