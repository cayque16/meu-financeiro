<?php

namespace Tests\Unit\App\Models;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurrencyUnitTest extends ModelTestCase
{
    protected function model(): Model
    {
        return new Currency();
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
            'name',
            'symbol',
            'iso_code',
            'split',
            'decimals',
            'description',
            'deleted_at',
            'created_at',
            'updated_at',
        ];
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
