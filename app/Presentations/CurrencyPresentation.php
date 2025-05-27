<?php

namespace App\Presentations;

use Core\Domain\Presentation\CurrencyPresentationInterface;

class CurrencyPresentation implements CurrencyPresentationInterface
{
    public function arrayToSelect(array $items): array
    {
        $result = [];
        foreach ($items as $asset) {
            $result[$asset->id()] = $asset->name;
        }
        return $result;
    }
}
