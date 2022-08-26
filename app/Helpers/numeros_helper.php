<?php 

function formata_moeda($valor, $exibirMoeda = 'R$')
{
    return $exibirMoeda ? 
        $exibirMoeda.' '.number_format($valor, 2, ',', '.') :
        number_format($valor, 2, ',', '.');
}