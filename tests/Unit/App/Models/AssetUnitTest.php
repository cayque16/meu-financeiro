<?php

namespace Tests\Unit\App\Models;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetUnitTest extends ModelTestCase
{
    protected function model(): Model
    {
        return new Asset();
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
            'code',
            'description',
            'assets_type_id',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'assets_type_id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
