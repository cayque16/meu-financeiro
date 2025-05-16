<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends MyModelAbstract
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'codigo',
        'descricao',
        'id_assets_type',
        'uuid_assets_type',
        'e_excluido',
        'created_at',
    ];

    protected $casts = [
        'uuid_assets_type'=> 'string',
        'created_at'=> 'datetime',
    ];

    public function __construct()
    {
        parent::__construct($this);
    }

    public function sltAssets($arrayStatus = [Status::ATIVADO])
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
        return $this->belongsTo(AssetsType::class, 'id_assets_type', 'id');
    }
}
