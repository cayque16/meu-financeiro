<?php 

function formata_moeda($valor, $exibirMoeda = 'R$')
{
    return $exibirMoeda ? 
        $exibirMoeda.' '.number_format($valor, 2, ',', '.') :
        number_format($valor, 2, ',', '.');
}

function formata_numero_br($valor)
{
    return number_format($valor, decimal_separator: ',', thousands_separator: '.');
}