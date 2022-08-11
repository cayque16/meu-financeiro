<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetsType extends Model
{
    protected $fillable = ['nome', 'descricao', 'e_excluido'];

    use HasFactory;

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function sltAssetsTypes($arrayStatus = [Status::ATIVADO])
    {
        return AssetsType::select('id', 'nome')
                ->whereIn('e_excluido', $arrayStatus)
                ->get()
                ->toArray();
    }
}
