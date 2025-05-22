<?php

namespace Tests\Unit\App\Models;

use App\Models\AssetsType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetTypeUnitTest extends ModelTestCase
{
    protected function model(): Model
    {
        return new AssetsType();
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
            'uuid',
            'nome',
            'descricao',
            'e_excluido',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
    }

    protected function casts(): array
    {
        return [
            'uuid' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'id' => 'int',
        ];
    }
}
