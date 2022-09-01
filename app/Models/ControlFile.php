<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ControlFile extends MyModelAbstract
{
    use HasFactory;

    protected $fillable = ['id_referencia', 'id_table_references', 'nome_original', 'extensao'];

    public function __construct()
    {
        parent::__construct($this);
    }
}
