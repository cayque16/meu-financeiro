<?php

function getUniqId()
{
    return md5(uniqid(rand(), true));
}

function hashNomeDeArquivos($nomeOriginal, $idReferencia, $tabelaReferencia)
{
    return md5($nomeOriginal.$idReferencia.$tabelaReferencia);
}