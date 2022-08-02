<?php

$container['loadingHelpers'] = function($c) {
    // $dir = "../../app/Helpers"; //app/Helpers
    $dir = (dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Helpers');

    if(!is_dir($dir)) {
        throw new Exception("Diretorio nao encontrado");
        exit(1);
    }

    $arrayHelpers = glob("$dir/*.php");

    foreach($arrayHelpers as $value){
        require $value;
    }
};