<?php

namespace Core\Domain\Entity;

class Order
{
    public function __construct(
        protected string $id,
        // protected string $date,
        // protected string $status,
        // protected string $idClient,
        protected OrderItems $items,
    ) { }

    public function totalAmount(): int
    {
        $total = 0;
        foreach($this->items as $item) {
            $total += $item->productQuantity;
        }

        return $total;
    }
}
