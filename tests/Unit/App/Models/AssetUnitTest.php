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
            'codigo',
            'descricao',
            'id_assets_type',
            'uuid_assets_type',
            'e_excluido',
            'created_at',
        ];
    }

    protected function casts(): array
    {
        return [
            'uuid_assets_type' => 'string',
            'created_at'  => 'datetime',
        ];
    }
}
