<?php

function formataDataBr($data, $mostraHora = true, $separador = " ") 
{
    if(!$data) return "";

    $data = date_create($data);
    $dataHora = date_format($data, 'd/m/Y H:i:s');

    list($data, $hora) = explode(" ", $dataHora);

    return $mostraHora ? $data.$separador.$hora : $data;
}