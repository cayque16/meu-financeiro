<?php

namespace Core\UseCase\DTO\AssetType\ListAssetsTypes;

class ListAssetsTypesInputDto
{
    public function __construct(
        public string $filter = '',
        public string $order = 'DESC',
    ) { }
}
