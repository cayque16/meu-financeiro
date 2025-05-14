<?php

namespace Core\Domain\Enum;

enum PaymentType: int
{
    case JCP = 1;

    case DIVIDENDOS = 2;
}
