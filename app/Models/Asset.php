<?php

namespace App\Models;

use App\Http\Requests\StoreAssetRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    public function getAll()
    {
        return Asset::all();
    }

    public function insAsset(StoreAssetRequest $request)
    {
        $this->codigo = $request->codigo;
        $this->descricao = $request->descricao;
        $this->id_assets_type = $request->id_assets_type;

        return $this->save();
    }

    public function assetsType()
    {
        return $this->belongsTo(AssetsType::class, 'id_assets_type', 'id');
    }
}
