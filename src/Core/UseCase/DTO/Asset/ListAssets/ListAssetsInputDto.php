<?php

namespace Core\UseCase\DTO\Asset\ListAssets;

class ListAssetsInputDto
{
    public function __construct(
        public string $filter = '',
        public string $order = 'DESC',
        public bool $includeInactive = true,
    ) { }
}
