<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $key;

    protected $value;

    protected function trataRetornoInsert($retorno)
    {
        list($this->key, $this->value) = $retorno ? 
            ['msg', 'Ativo criado com sucesso!'] : 
            ['erro', 'Houve um erro ao inserir o ativo!'];
    }
}
