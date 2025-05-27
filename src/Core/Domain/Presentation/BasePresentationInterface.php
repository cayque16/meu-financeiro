<?php

namespace Core\Domain\Presentation;

interface BasePresentationInterface
{
    public function arrayToSelect(array $items): array;
}
