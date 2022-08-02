<?php

namespace middlewares\injection;

use Exception;

class DI
{
    public static function __callStatic($name, $arguments)
    {
        try {
            return (new Manager)->getContainer()[$name];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}