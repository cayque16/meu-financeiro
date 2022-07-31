<?php

function getBtn($tipo = null, $id = null)
{
    $teste = [
        1 => ['text' => 'text-primary', 'msg' => 'Editar', 'icon' => 'pen'],
        2 => ['text' => 'text-danger', 'msg' => 'Excluir', 'icon' => 'trash'],
    ];
    
    $button = '<button class="btn btn-xs btn-default %s mx-1 shadow" title="%s">
            <i class="fa fa-lg fa-fw fa-%s"></i>
        </button>';
        
    return sprintf($button, $teste[$tipo]['text'], $teste[$tipo]['msg'], $teste[$tipo]['icon']);
}