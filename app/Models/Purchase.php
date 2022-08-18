<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends MyModelAbstract
{
    use HasFactory;

    protected $fillable = ['data', 'e_excluido', 'id_brokerages'];

    public function __construct()
    {
        parent::__construct($this);
    }

    public function lstPurchasePorAno($ano)
    {
        
    }
}
