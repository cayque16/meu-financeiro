<?php

use App\Enums\ButtonType;

function getBtnLink($tipo, $link = '#')
{
    $arrayDados = [
        ButtonType::EDITAR => ['class' => 'btn-outline-info', 'msg' => '', 'icon' => 'pen', 'divOpen' => "", 'divClose' => ""],
        ButtonType::EXCLUIR => ['class' => 'btn-outline-danger', 'msg' => '', 'icon' => 'trash', 'divOpen' => "", 'divClose' => ""],
        ButtonType::INCLUIR => ['class' => 'btn-success btn-add', 'msg' => 'Incluir', 'icon' => 'plus', 'divOpen' => "<div class=\"div-btn-add\">", 'divClose' => "</div>"],
        ButtonType::VOLTAR => ['class' => 'btn-outline-success', 'msg' => 'Voltar', 'icon' => 'arrow-left', 'divOpen' => "", 'divClose' => ""],
    ];

    $button = "<a class=\"btn %s\" href=\"$link\"><i class=\"fas fa-%s\"></i> %s</a>";

    return sprintf($arrayDados[$tipo]['divOpen'].$button.$arrayDados[$tipo]['divClose'], $arrayDados[$tipo]['class'], $arrayDados[$tipo]['icon'], $arrayDados[$tipo]['msg']);
}