<?php

namespace App\Presentations;

use Core\Domain\Presentation\AssetPresentationInterface;

class AssetPresentation implements AssetPresentationInterface
{
    public function arrayToSelect(array $items): array
    {
        $result = [];
        foreach ($items as $asset) {
            $result[$asset->id()] = $asset->code;
        }
        return $result;
    }
}
