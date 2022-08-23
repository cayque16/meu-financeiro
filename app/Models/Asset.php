<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends MyModelAbstract
{
    protected $fillable = ['codigo', 'descricao', 'id_assets_type', 'e_excluido'];

    use HasFactory;

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
