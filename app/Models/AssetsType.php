<?php

namespace App\Models;

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
}
