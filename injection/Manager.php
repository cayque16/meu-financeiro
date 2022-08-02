<?php

namespace middlewares\injection;

use Exception;
use middlewares\injection\DependencyManager as InjectionDependencyManager;

class Manager
{
    public $pimple;

    public function __construct()
    {   
        $this->pimple = new InjectionDependencyManager();

        self::initDependencies();
    }

    public function initDependencies()
    {
        self::requireAllDependencies(__DIR__."/dependencies");
    }

    public function requireAllDependencies($directory)
    {
        try {
            $container = $this->getContainer();
            $dir = "{$directory}/*.php";

            foreach(glob($dir) as $filename) {
                include $filename;
                $this->pimple->add($container);
            }
        } catch (Exception $e) {
            echo "Erro ao tentar adicionar o arquivo: ".$e->getMessage();
        }
    }

    public function getContainer()
    {
        return $this->pimple->container();
    }
}