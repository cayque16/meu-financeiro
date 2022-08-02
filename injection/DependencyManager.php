<?php

namespace middlewares\injection;

use Pimple\Container;

class DependencyManager
{
    private $container;

    public function __construct($container = [])
    {
        if (is_array($container)) {
            $container = new Container($container);
        }
        $this->container = $container;
    }

    public function container()
    {
        return $this->container;
    }

    public function add($container)
    {
        $c = $this->container();

        foreach ($container as $key => $value) {
            $c->offetSet($key, $value);
        }
    }
}