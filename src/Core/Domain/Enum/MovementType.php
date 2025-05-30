<?php

namespace Core\Domain\Enum;

enum MovementType: string
{
    case PURCHASE = "Compra";

    case SALE = "Venda";
}
