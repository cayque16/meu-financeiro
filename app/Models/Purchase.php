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

    public function sqlListaOsAnosDeCompras()
    {
        $query = Purchase::select('data')->groupBy('data');
        
        $datas = $query->get()->toArray();

        $retorno = [];
        array_walk($datas, function($dado) use (&$retorno) {
            $data = date_create($dado['data']);
            $ano = date_format($data, 'Y');
            $retorno[$ano] = $ano;
        });
        return $retorno;
    }
}
