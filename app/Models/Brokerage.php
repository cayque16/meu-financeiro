<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brokerage extends MyModelAbstract
{
    protected $fillable = ['nome', 'site', 'cnpj', 'e_excluido'];

    use HasFactory;

    public function __construct()
    {
        parent::__construct($this);
    }
}
