<?php

function getBtn($tipo = null, $id = null)
{
    $arrayDados = [
        Botoes::EDITAR->value => ['text' => 'text-primary', 'msg' => 'Editar', 'icon' => 'pen'],
        Botoes::EXCLUIR->value => ['text' => 'text-danger', 'msg' => 'Excluir', 'icon' => 'trash'],
    ];
    
    $button = '<button class="btn btn-xs btn-default %s mx-1 shadow" title="%s">
            <i class="fa fa-lg fa-fw fa-%s"></i>
        </button>';
        
    return sprintf($button, $arrayDados[$tipo]['text'], $arrayDados[$tipo]['msg'], $arrayDados[$tipo]['icon']);
}