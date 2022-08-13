<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends MyModelAbstract
{
    protected $fillable = ['codigo', 'descricao', 'id_assets_type', 'e_excluido'];

    use HasFactory;

    public function __construct()
    {
        parent::__construct($this);
    }

    public function assetsType()
    {
        return $this->belongsTo(AssetsType::class, 'id_assets_type', 'id');
    }
}
