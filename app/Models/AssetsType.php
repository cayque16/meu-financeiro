<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\MyModelAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetsType extends MyModelAbstract
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'uuid',
        'nome',
        'descricao',
        'e_excluido',
        'created_at'
    ];

    protected $casts = [
        'uuid'=> 'string',
        'created_at'=> 'datetime',
    ];

    public function __construct()
    {
        parent::__construct($this);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function sltAssetsTypes($arrayStatus = [Status::ATIVADO])
    {
        return AssetsType::select('id', 'nome')
                ->whereIn('e_excluido', $arrayStatus)
                ->orderBy('nome')
                ->get()
                ->toArray();
    }
}
