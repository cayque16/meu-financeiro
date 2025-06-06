<?php

use App\Enums\ButtonType;

function getBtnLink($tipo, $link = '#', $title = '', $target = null)
{
    $arrayDados = [
        ButtonType::EDIT => ['id' => 'editar', 'title' => 'Editar', 'class' => 'btn-outline-info', 'msg' => '', 'icon' => 'pen', 'divOpen' => "", 'divClose' => ""],
        ButtonType::DISABLE => ['id' => 'desativar', 'title' => 'Desativar', 'class' => 'btn-outline-danger', 'msg' => '', 'icon' => 'ban', 'divOpen' => "", 'divClose' => ""],
        ButtonType::INCLUDE => ['id' => 'incluir', 'title' => 'Incluir novo registro', 'class' => 'btn-success btn-add', 'msg' => 'Incluir', 'icon' => 'plus', 'divOpen' => "<div class=\"div-btn-add\">", 'divClose' => "</div>"],
        ButtonType::BACK => ['id' => 'voltar', 'title' => 'Voltar para a página anterior', 'class' => 'btn-voltar btn-outline-success', 'msg' => 'Voltar', 'icon' => 'arrow-left', 'divOpen' => "", 'divClose' => ""],
        ButtonType::ACTIVATE => ['id' => 'ativar', 'title' => 'Ativar', 'class' => 'btn-outline-success', 'msg' => '', 'icon' => 'check', 'divOpen' => "", 'divClose' => ""],
        ButtonType::DISPLAY => ['id' => 'exibir', 'title' => 'Exibir', 'class' => 'btn-outline-warning', 'msg' => '', 'icon' => 'eye', 'divOpen' => "", 'divClose' => ""],
        ButtonType::PDF => ['id' => 'pdf', 'title' => $title, 'class' => 'btn-outline-danger', 'msg' => '', 'icon' => 'file-pdf', 'divOpen' => "", 'divClose' => ""],
    ];
    
    $target = $target ? "target='$target'" : null;
    
    $button = "<a id='%s'  title='%s' $target class=\"btn %s\" href=\"$link\"><i class=\"fas fa-%s\"></i> %s</a>";

    return sprintf($arrayDados[$tipo]['divOpen'].$button.$arrayDados[$tipo]['divClose'], $arrayDados[$tipo]['id'], $arrayDados[$tipo]['title'], $arrayDados[$tipo]['class'], $arrayDados[$tipo]['icon'], $arrayDados[$tipo]['msg']);
}