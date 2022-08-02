<?php

use App\Enums\ButtonType;

function getBtn($tipo = null, $id = null, $link = null)
{
    if($tipo === ButtonType::INCLUIR) {
        return "<div class=\"div-btn-add\">
                <a class=\"btn btn-success btn-add\" href=\"$link\"><i class=\"fas fa-plus\"></i></a>
            </div>";
    }
    
    $arrayDados = [
        ButtonType::EDITAR => ['text' => 'text-primary', 'msg' => 'Editar', 'icon' => 'pen'],
        ButtonType::EXCLUIR => ['text' => 'text-danger', 'msg' => 'Excluir', 'icon' => 'trash'],
    ];
    
    $button = '<button class="btn btn-xs btn-default %s mx-1 shadow" title="%s">
            <i class="fa fa-lg fa-fw fa-%s"></i>
        </button>';
        
    return sprintf($button, $arrayDados[$tipo]['text'], $arrayDados[$tipo]['msg'], $arrayDados[$tipo]['icon']);
}