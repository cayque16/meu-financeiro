<?php

namespace Core\Domain\Entity\ExemploArrayTipado;

use ArrayIterator;
use IteratorIterator;

class OrderItems extends IteratorIterator
{
    private $arrayIterator;

    public function __construct(protected string $idOrder)
    {
        $this->arrayIterator = new ArrayIterator();
        parent::__construct($this->arrayIterator);
    }

    public function append(Item $item): void
    {
        $this->arrayIterator->offsetSet(null, $item);
    }
}

class Item
{
    public function __construct(
        public string $idProduct,
        public int $productQuantity
    ) { }
}
