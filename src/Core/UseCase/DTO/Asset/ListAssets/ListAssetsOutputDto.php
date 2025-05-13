<?php

namespace Core\UseCase\DTO\Asset\ListAssets;

class ListAssetsOutputDto
{
    public function __construct(
        public array $items
    ) { }
}
