<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'codigo',
        'descricao',
        'id_assets_type',
        'uuid_assets_type',
        'e_excluido',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'uuid_assets_type'=> 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // public function __construct()
    // {
    //     parent::__construct($this);
    // }

    public function sltAssets($arrayStatus = [Status::ACTIVE])
    {
        $result = Asset::select('id', 'codigo')
            ->whereIn('e_excluido', $arrayStatus)
            ->orderBy('codigo')
            ->get()
            ->toArray();

        return array_column($result, 'codigo', 'id');
    }

    public function assetsType()
    {
        return $this->hasOne(AssetsType::class, 'uuid', 'uuid_assets_type');
    }
}
